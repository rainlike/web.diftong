<?php
/**
 * ValueType Storage
 * Contains existing useful records of ValueType
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
namespace App\Entity\Storage;

/** Class ValueTypeStorage */
class ValueTypeStorage
{
    /**
     * Name of value for showing topbar
     * @var string
     */
    public const GLOBAL_SHOW_TOPBAR = 'global_show_topbar';

    /**
     * Name of value for setting logo as link
     * @var string
     */
    public const HEADER_LOGO_AS_LINK = 'header_logo_as_link';

    /**
     * Name of value for showing user action button in header
     * @var string
     */
    public const HEADER_SHOW_USER_ACTION = 'header_show_user_action';

    /**
     * Name of value for showing search action button in header
     * @var string
     */
    public const HEADER_SHOW_SEARCH_ACTION = 'header_show_search_action';

    /**
     * Name of value for styling buttons in header
     * @var string
     */
    public const HEADER_FLAT_ACTIONS = 'header_flat_actions';

    /**
     * Name of value for showing social share icons in footer
     * @var string
     */
    public const FOOTER_SHOW_SOCIALS = 'footer_show_socials';

    /**
     * Name of value for showing grammar in menu
     * @var string
     */
    public const MENU_SHOW_GRAMMAR = 'menu_show_grammar';

    /**
     * Name of value for showing phonetics in menu
     * @var string
     */
    public const MENU_SHOW_PHONETICS = 'menu_show_phonetics';

    /**
     * Name of value for showing lexis in menu
     * @var string
     */
    public const MENU_SHOW_LEXIS = 'menu_show_lexis';

    /**
     * Name of value for showing articles in menu
     * @var string
     */
    public const MENU_SHOW_ARTICLES = 'menu_show_articles';

    /**
     * Name of value for showing topics in menu
     * @var string
     */
    public const MENU_SHOW_TOPICS = 'menu_show_topics';

    /**
     * Name of value for showing lyrics in menu
     * @var string
     */
    public const MENU_SHOW_LYRICS = 'menu_show_lyrics';

    /**
     * Name of value for showing bottom breadcrumbs on the theory page
     * @var string
     */
    public const THEORY_SHOW_BOTTOM_BREADCRUMBS = 'menu_show_lyrics';
}
