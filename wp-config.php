<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_fb5ckb35hk');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Ozot$siSR&IkxWH;iiL^>a]_t;Tn*cEgr;jD*htnR^oYzEy=N%*_VZxheL;Z+Xv^UpYwlOK|yEA<edUk@I-ohFS?p(fW?lGy^<_oxVEdMOXA(aoDQFPfqF;zH=QxAdnq');
define('SECURE_AUTH_KEY', ']l!QGJA_W!xDlXlegJ_+s_RUpX*nig_SiurhcTJ<A&crWiWxy!ub@DS!{SOoXMi-NPKP@xXVcIS{XFr|>Ys+OA*&CFaLeR;$zHy@tk]Q+JdTGc]Diqtn{!ntaRbq-;GY');
define('LOGGED_IN_KEY', 'rTdzLGf*F<T_&r%IkjbMGh!+N;W_[aeHndvhE!I%(NP|F;+B>r!>n<@IFzhx|kpG%PJJBBXT?nQY;pB)>AfBYITRxgN}d!xOA!wT=&-ynTAdoNRh*XTSDkz>BUXCl{WW');
define('NONCE_KEY', '|C|{<qD_lp_I<FQMsfnR!;GZXhIPLUWXHVcI<T-tao<$PTc{}z?K(HrfitdefRPnsQ/)xOAK}TFyi@@O_L_F}SAwr*+i-wv?jK;%nt!m}JbnBTY@TXyd&?n^z_LX[_Bh');
define('AUTH_SALT', 'i;UR?r__x_lHYWi[a_<Hb*db&ZFM}d%r_gEc{PgjSnX+(jGx?lFygU+b-QgC*C@irA>PHCJ)hziueG>i|OwJ;;][)RsO$yxuZXZMdI)RFlmgi|u+)eMMx+erl;DOqs[A');
define('SECURE_AUTH_SALT', ')(;lI[;aX}iK_}r<zlZx-hToBtRxhInezJcnBu|=?];rFJPue|Jtp>fj}Rgir>i|huJ<]wiTLE&gUp$gqsqqWzA+@OqMrc^HvH!+k?Zz(?TFBSU&=%E@pMKl{W%wCAEj');
define('LOGGED_IN_SALT', 'cTlSFT>E-_sNyDBf_!qY{(&Rx%HRwfDn?D?$[$FRMES$=b+Pfnz=r=Pw_SA-CV$PV>&Sn{/peKMteSytU]pgK_NvsCey%RH&IAFRV&J^)*c(u&duRA>/^AFQY)q?rwD/');
define('NONCE_SALT', 'bO|@hFDe}aWTO)z*Dky!|&<tk%gBIOCKN;Gomdr+-?TaqZbB+fmJ=)IFtJ;na^<+VaLyKbT/IgbbZhdh;n|qEXQOLxTA$f>NfDyIl_TE]VUo@N=jBhG<SES_]ccLOHA@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_apyo_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
