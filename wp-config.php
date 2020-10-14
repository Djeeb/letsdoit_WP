<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

 define('DISABLE_WP_CRON', true);

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'letsdoit' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'sp /)+5`##K[3-Yo=_u@4keH$Aq.~lIKUBr@/;Cfljx/{QtHZB~@p~RAzmH6G%<H' );
define( 'SECURE_AUTH_KEY',  'Lo,Ze%E^6O.LC>e{-f_[Y 6:ff}BQj5|9hcshxiFWipx#z;A)Y;^o.QXbxYs~7cj' );
define( 'LOGGED_IN_KEY',    'jGp&6DJZ48W>X:{},jj(2+zrN@ca^!j(,AMc7a1[a-Bs0sonTDC4E8h7$1y:]:(Y' );
define( 'NONCE_KEY',        '!(l>hlc]S =wABc?t<%o-ukkmth/pdJGkyp_Qd.k7N@DxJfYVe_VCyxa5$+Q]VRG' );
define( 'AUTH_SALT',        'w]LT=Smd[}h@taen02wN!%C4O|[X8>1MM4]Fr*.DohN](}ih[UfVi<PnI#D@%-*R' );
define( 'SECURE_AUTH_SALT', 'w9E{e|~HCp%fVQv^wLhqZ7cs:.[ABFZBfMzfN#bbl9}G@~1)ib0LEpr5`i[/<:k8' );
define( 'LOGGED_IN_SALT',   'HPlgg[*UYV2*RjqXhII`n:2CkStGyNV<?W&31LHxz|[%-4gTOG|rK>WB[L=<ZwV|' );
define( 'NONCE_SALT',       'MsDOtc_t;P+?,/;=)wbW*O/MS{P~JEm)znx5N:W;qq0GPWOIxgs BmO?g_WA8.d<' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );

define('FS_METHOD','direct');