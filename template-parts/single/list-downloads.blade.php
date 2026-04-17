@php
  $downloads = !empty($downloads) ? array_filter($downloads, function ($download) { return !empty($download['active']); }) : [];
  $hasAudio = !empty(array_filter($downloads, function ($d) { return in_array(strtolower($d['format']), ['mp3', 'ogg', 'wav', 'aac', 'm4a']); }));
@endphp

@notempty($downloads)
  <table class="pa-downloads-table table table-hover align-middle">
    <caption class="d-none"><?= __('Download', 'downloads')  ?></caption>
    <thead>
      <tr>
        <th class="px-3 border-0 d-none d-lg-table-cell" scope="col">{{ __('Name', 'downloads') }}</th>

        <th class="px-3 border-0 d-none d-lg-table-cell" scope="col">{{ __('Size', 'downloads') }}</th>

        <th class="pa-downloads-table__fit px-3 border-0 text-end d-none d-lg-table-cell" scope="col">{{ __('Download', 'downloads') }}</th>

        {{-- <th class="px-0 border-0 d-block d-lg-none" scope="col">{{ __('Files for download', 'downloads') }}</th> --}}
      </tr>
    </thead>

    <tbody>
      @foreach($downloads as $download)
        @php $isAudio = in_array(strtolower($download['format']), ['mp3', 'ogg', 'wav', 'aac', 'm4a']); @endphp
        <tr>
          <td class="py-3 px-3 pe-lg-3">
            <span class="pa-truncate-1" title="{!! $loop->iteration . '. ' . wp_strip_all_tags($download['name']) !!}">
                @if($download['format'] !== 'link')
                        <i class="fas fa-file-{{ strtolower($download['format']) }} me-2"></i>
                @endif

                @if($download['format'] !== 'link')
                <span class="pa-tag rounded-1 text-uppercase d-inline-block px-1 me-2">{{ $download['format'] }}</span>
              {!! wp_strip_all_tags($download['name']) !!}
              {{-- {!! $loop->iteration . '. ' . wp_strip_all_tags($download['name']) !!} --}}
            </span>
                @else
              {!! wp_strip_all_tags($download['name']) !!}
              {{-- {!! $loop->iteration . '. ' . wp_strip_all_tags($download['name']) !!} --}}
            </span>
            @endif
          </td>

          @if($download['format'] !== 'link')
            <td class="p-3">{{ size_format($download['size']*1024*1024, 0) }}</td>
          @else
            <td></td>
          @endif
          <td class="pa-downloads-table__fit py-3 px-0 px-lg-3 fw-bold">
            <div class="d-flex align-items-center gap-3">
              @if($isAudio)
                <button class="pa-audio-btn text-decoration-none d-flex align-items-center p-0 fw-bold" data-audio-src="{{ $download['link'] }}" data-audio-name="{{ wp_strip_all_tags($download['name']) }}" type="button" aria-label="{{ __('Listen', 'downloads') }}">
                  <i class="fas fa-play"></i>
                </button>
              @endif
              <a class="text-decoration-none d-flex align-items-center" href="{{ iconv("UTF-8","ISO-8859-1//IGNORE",$download['link']) }}" target="_blank">
                @if($download['format'] !== 'link')
                <i class="fas fa-download me-2"></i>
                <span class="d-none d-lg-inline-block"><?= __('Download', 'downloads')  ?></span>
                @else
                <i class="fas fa-link me-2"></i>
                <span class="d-none d-lg-inline-block"><?= __('Open', 'downloads')  ?></span>
                @endif
              </a>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if($hasAudio)
    <dialog class="pa-audio-dialog" id="pa-audio-dialog">
      <div class="pa-audio-dialog__header">
        <span class="pa-audio-dialog__title"></span>
        <button class="pa-audio-dialog__close" type="button" aria-label="{{ __('Close', 'downloads') }}">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="pa-audio-dialog__controls">
        <button class="pa-audio-dialog__play" type="button" aria-label="Play">
          <i class="fas fa-play"></i>
        </button>
        <span class="pa-audio-dialog__time pa-audio-dialog__current">0:00</span>
        <div class="pa-audio-dialog__progress">
          <div class="pa-audio-dialog__progress-fill"></div>
          <input class="pa-audio-dialog__seek" type="range" min="0" max="100" value="0" step="0.1" aria-label="Seek">
        </div>
        <span class="pa-audio-dialog__time pa-audio-dialog__duration">0:00</span>
        <div class="pa-audio-dialog__volume">
          <button class="pa-audio-dialog__mute" type="button" aria-label="Mute">
            <i class="fas fa-volume-up"></i>
          </button>
          <input class="pa-audio-dialog__volume-slider" type="range" min="0" max="1" value="1" step="0.01" aria-label="Volume">
        </div>
      </div>
      <audio preload="none"></audio>
    </dialog>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var dialog = document.getElementById('pa-audio-dialog');
        var audio = dialog.querySelector('audio');
        var title = dialog.querySelector('.pa-audio-dialog__title');
        var closeBtn = dialog.querySelector('.pa-audio-dialog__close');
        var playBtn = dialog.querySelector('.pa-audio-dialog__play');
        var seekBar = dialog.querySelector('.pa-audio-dialog__seek');
        var progressFill = dialog.querySelector('.pa-audio-dialog__progress-fill');
        var currentTime = dialog.querySelector('.pa-audio-dialog__current');
        var durationEl = dialog.querySelector('.pa-audio-dialog__duration');
        var muteBtn = dialog.querySelector('.pa-audio-dialog__mute');
        var volumeSlider = dialog.querySelector('.pa-audio-dialog__volume-slider');
        var activeBtn = null;

        function formatTime(s) {
          if (isNaN(s)) return '0:00';
          var m = Math.floor(s / 60);
          var sec = Math.floor(s % 60);
          return m + ':' + (sec < 10 ? '0' : '') + sec;
        }

        function resetIcons() {
          document.querySelectorAll('.pa-audio-btn i').forEach(function (i) {
            i.classList.remove('fa-pause');
            i.classList.add('fa-play');
          });
        }

        function setPlaying(playing) {
          var icon = playBtn.querySelector('i');
          icon.classList.toggle('fa-play', !playing);
          icon.classList.toggle('fa-pause', playing);
        }

        document.querySelectorAll('.pa-audio-btn').forEach(function (btn) {
          btn.addEventListener('click', function () {
            var src = btn.getAttribute('data-audio-src');
            var name = btn.getAttribute('data-audio-name');

            resetIcons();

            if (dialog.open && audio.src === src) {
              audio.pause();
              dialog.close();
              return;
            }

            audio.src = src;
            title.textContent = name;
            activeBtn = btn;
            btn.querySelector('i').classList.remove('fa-play');
            btn.querySelector('i').classList.add('fa-pause');
            setPlaying(true);
            dialog.showModal();
            audio.play();
          });
        });

        playBtn.addEventListener('click', function () {
          if (audio.paused) {
            audio.play();
            setPlaying(true);
            if (activeBtn) {
              activeBtn.querySelector('i').classList.remove('fa-play');
              activeBtn.querySelector('i').classList.add('fa-pause');
            }
          } else {
            audio.pause();
            setPlaying(false);
            if (activeBtn) {
              activeBtn.querySelector('i').classList.remove('fa-pause');
              activeBtn.querySelector('i').classList.add('fa-play');
            }
          }
        });

        audio.addEventListener('loadedmetadata', function () {
          durationEl.textContent = formatTime(audio.duration);
          seekBar.max = audio.duration;
        });

        audio.addEventListener('timeupdate', function () {
          currentTime.textContent = formatTime(audio.currentTime);
          seekBar.value = audio.currentTime;
          var pct = (audio.currentTime / audio.duration) * 100 || 0;
          progressFill.style.width = pct + '%';
        });

        seekBar.addEventListener('input', function () {
          audio.currentTime = seekBar.value;
        });

        muteBtn.addEventListener('click', function () {
          audio.muted = !audio.muted;
          var icon = muteBtn.querySelector('i');
          icon.classList.toggle('fa-volume-up', !audio.muted);
          icon.classList.toggle('fa-volume-mute', audio.muted);
        });

        volumeSlider.addEventListener('input', function () {
          audio.volume = volumeSlider.value;
          audio.muted = false;
          var icon = muteBtn.querySelector('i');
          icon.classList.remove('fa-volume-mute');
          icon.classList.add('fa-volume-up');
        });

        closeBtn.addEventListener('click', function () {
          audio.pause();
          dialog.close();
        });

        dialog.addEventListener('close', function () {
          audio.pause();
          audio.currentTime = 0;
          audio.src = '';
          setPlaying(false);
          progressFill.style.width = '0%';
          seekBar.value = 0;
          currentTime.textContent = '0:00';
          durationEl.textContent = '0:00';
          resetIcons();
          activeBtn = null;
        });

        audio.addEventListener('ended', function () {
          setPlaying(false);
          resetIcons();
        });
      });
    </script>
  @endif
@endnotempty