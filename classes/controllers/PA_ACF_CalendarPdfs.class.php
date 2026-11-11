<?php

use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;

/**
 * Editable list of PDF links shown in the "PDF" dropdown of the events calendar bar
 * (tribe/events/v2/components/events-bar/views/list.php).
 */
class PaAcfCalendarPdfs
{
  const PAGE_SLUG = 'calendar_pdfs';
  const FIELD     = 'calendar_pdfs';

  /**
   * Used while the option has no rows (e.g. right after deploy).
   */
  const FALLBACK = [
    ['label' => 'Atividades',           'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20e%20Plano%20Ac%CC%A7a%CC%83o%20UPASD%20%202026.pdf'],
    ['label' => 'Datas Sugestivas',     'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/Datas%20Sugestivas%20UPASD%202026.pdf'],
    ['label' => 'RTP 2 / RTP Antena 1', 'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/comunicacao/calendarios/2026/RTP.pdf'],
    ['label' => 'Oração',               'url' => 'https://s3.eu-central-003.backblazeb2.com/upasd-recursos/ministerial/calendarios/2026/Ora%C3%A7%C3%A3o.pdf'],
  ];

  public function __construct()
  {
    add_action('acf/init', [$this, 'addOptionsPage']);
    add_action('acf/init', [$this, 'createAcfFields']);
    add_action('wp_enqueue_scripts', [$this, 'enqueueStyles'], 20);
  }

  /**
   * Calendar CSS overrides, inlined after the theme stylesheet so no style.css rebuild is needed.
   */
  function enqueueStyles()
  {
    wp_add_inline_style('pa-child-style', <<<'CSS'
/*
 * The Events Calendar's events-bar.js hides the view selector list (jQuery .hide())
 * whenever focus leaves it. On desktop that list is the always-visible tab row, and
 * our "PDF" toggle is the only item in it that takes focus without navigating, so
 * opening the PDF menu and clicking elsewhere hid Lista/Mês/PDF. Keep the tab row
 * visible on desktop; on mobile it is a real dropdown and the plugin's close is wanted.
 */
.tribe-common--breakpoint-medium .tribe-events-c-view-selector--tabs .tribe-events-c-view-selector__content{display:block!important}

/*
 * Use the site colour (--pa-color-default, set on body) instead of TEC's default #334aff.
 * TEC declares these on :root, where its var() chains are already resolved, so every
 * link of the chain is redeclared here on body, where --pa-color-default exists.
 */
body{
  --tec-color-accent-primary:var(--pa-color-default);
  --tec-color-accent-primary-hover:var(--pa-color-default-dark);
  --tec-color-accent-primary-active:var(--pa-color-default-dark);
  --tec-color-accent-primary-background:color-mix(in srgb,var(--pa-color-default) 7%,transparent);
  --tec-color-accent-primary-background-datepicker:var(--tec-color-accent-primary-background);
  --tec-color-accent-primary-week-event:color-mix(in srgb,var(--pa-color-default) 10%,transparent);
  --tec-color-accent-primary-week-event-hover:color-mix(in srgb,var(--pa-color-default) 20%,transparent);
  --tec-color-accent-primary-week-event-featured:color-mix(in srgb,var(--pa-color-default) 4%,transparent);
  --tec-color-accent-primary-week-event-featured-hover:color-mix(in srgb,var(--pa-color-default) 14%,transparent);
  --tec-color-background-primary-multiday:color-mix(in srgb,var(--pa-color-default) 24%,transparent);
  --tec-color-background-primary-multiday-hover:color-mix(in srgb,var(--pa-color-default) 34%,transparent);
  --tec-color-button-primary:var(--tec-color-accent-primary);
  --tec-color-button-primary-hover:var(--tec-color-accent-primary-hover);
  --tec-color-button-primary-active:var(--tec-color-accent-primary-active);
  --tec-color-button-primary-background:var(--tec-color-accent-primary-background);
  --tec-color-background-events-bar-submit-button:var(--tec-color-button-primary);
  --tec-color-background-events-bar-submit-button-hover:var(--tec-color-button-primary-hover);
  --tec-color-background-events-bar-submit-button-active:var(--tec-color-button-primary-active);
  --tec-color-link-accent:var(--tec-color-accent-primary);
  --tec-color-link-accent-hover:var(--tec-color-accent-primary-hover);
  --tec-color-icon-focus:var(--tec-color-accent-primary);
  --tec-color-event-icon-hover:var(--tec-color-accent-primary);
  --tec-form-color-accent-primary:var(--tec-color-accent-primary);
  --tec-color-category-legend-default-1:var(--tec-color-accent-primary);
}

/* Search button: site font and uppercase, like .pa-btn */
.tribe-events .tribe-events-c-search__button,
.tribe-events button.tribe-events-c-search__button{
  font-family:var(--pa-font-default);
  text-transform:uppercase;
  letter-spacing:.02em;
}
CSS
    );
  }

  function addOptionsPage()
  {
    acf_add_options_sub_page([
      'page_title'  => __('Calendar PDFs', 'downloads'),
      'menu_title'  => __('Calendar PDFs', 'downloads'),
      'menu_slug'   => self::PAGE_SLUG,
      'parent_slug' => 'edit.php?post_type=tribe_events',
      'capability'  => 'edit_others_posts',
    ]);
  }

  function createAcfFields()
  {
    register_extended_field_group([
      'title'  => __('Calendar PDFs', 'downloads'),
      'key'    => 'calendar_pdfs_settings',
      'style'  => 'default',
      'fields' => [
        Repeater::make(__('Links', 'downloads'), self::FIELD)
          ->instructions(__('Links shown in the "PDF" menu of the events calendar. If empty, the built-in 2026 links are shown.', 'downloads'))
          ->buttonLabel(__('Add PDF', 'downloads'))
          ->layout('table')
          ->fields([
            Text::make(__('Label', 'downloads'), 'label')->required(),
            Url::make(__('URL', 'downloads'), 'url')->required(),
          ]),
      ],
      'location' => [
        Location::where('options_page', self::PAGE_SLUG),
      ],
    ]);
  }

  /**
   * @return array<int, array{label: string, url: string}>
   */
  public static function getLinks(): array
  {
    $rows = function_exists('get_field') ? get_field(self::FIELD, 'option') : null;

    $links = array_values(array_filter((array) $rows, function ($row) {
      return is_array($row) && !empty($row['label']) && !empty($row['url']);
    }));

    return $links ?: self::FALLBACK;
  }
}

$PaAcfCalendarPdfs = new PaAcfCalendarPdfs();
