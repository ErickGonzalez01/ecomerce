<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Almacena la configuración predeterminada para el contenido de la capacidad
 * Elija usarlo.Los valores aquí se leerán y se establecerán como predeterminados
 * Para el sitio.Si es necesario, pueden ser anulados por página por página.
 *
 * Referencia sugerida para explicaciones:
 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    // -------------------------------------------------------------------------
    // Broadbrush CSP management
    // -------------------------------------------------------------------------

    /**
     * Contexto de informe de CSP predeterminado
     */
    public bool $reportOnly = false;

    /**
     * Especifica una URL en la que un navegador enviará informes
     * Cuando se viola una política de seguridad de contenido.
     */
    public ?string $reportURI = null;

    /**
     * Instruye a los agentes de los usuarios que reescriban esquemas de URL, cambiando
     * Http a https.Esta directiva es para sitios web con
     * Grandes cantidades de URL antiguas que necesitan ser reescritas.
     */
    public bool $upgradeInsecureRequests = false;

    // -------------------------------------------------------------------------
    //Fuentes permitidas
    // NOTA: Una vez que establece una política en 'Ninguno', no se puede restringir aún más
    //-------------------------------------------------------------------------

    /**
     * Ponaldeo a uno mismo si no se anula
     *
     * @var string|string[]|null
     */
    public $defaultSrc='self';

    /**
     * Las listas permitieron las URL de los scripts.
     *
     * @var string|string[]
     */
    public $scriptSrc = 'self';

    /**
     * Las listas permitieron las URL de hojas de estilo.
     *
     * @var string|string[]
     */
    public $styleSrc = ["'self'","'sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM'"];
    //style-src 'self' https://cdn.jsdelivr.net 'nonce-c9e2a42ab59438939b35c2bd'

    /**
     * Define los orígenes de los que se pueden cargar imágenes.
     *
     * @var string|string[]
     */
    public $imageSrc = 'self';

    /**
     * Restringe las URL que pueden aparecer en el elemento `<base>` de una página.
     *
     * Se debe por defecto a uno mismo si no se anula
     *
     * @var string|string[]|null
     */
    public $baseURI='self';

    /**
     * Enumera las URL para trabajadores y contenidos de cuadro integrado
     *
     * @var string|string[]
     */
    public $childSrc = 'self';

    /**
     * Limita los orígenes a los que puede conectarse (a través de XHR,
     * WebSockets y eventsource).
     *
     * @var string|string[]
     */
    public $connectSrc = 'self';

    /**
     * Especifica los orígenes que pueden servir fuentes web.
     *
     * @var string|string[]
     */
    public $fontSrc;

    /**
     * Enumera los puntos finales válidos para el envío de las etiquetas `<form>`.
     *
     * @var string|string[]
     */
    public $formAction = 'self';

    /**
     * Especifica las fuentes que pueden incrustar la página actual.
     * Esta directiva se aplica a `<Frame>`, `<iframe>`, `<griT>`,
     * y `<Applet>` etiquetas.Esta directiva no se puede usar en
     * `<META>` Etiquetas y se aplica solo a los recursos no HTML.
     *
     * @var string|string[]|null
     */
    public $frameAncestors;

    /**
     * La Directiva Frame-SRC restringe las URL que pueden
     * estar cargado en contextos de navegación anidados.
     *
     * @var array|string|null
     */
    public $frameSrc;

    /**
     * Restringe los orígenes permitidos para entregar video y audio.
     *
     * @var string|string[]|null
     */
    public $mediaSrc;

    /**
     * Permite el control sobre flash y otros complementos.
     *
     * @var string|string[]
     */
    public $objectSrc = 'self';

    /**
     * @var string|string[]|null
     */
    public $manifestSrc;

    /**
     * Limita los tipos de complementos que una página puede invocar.
     *
     * @var string|string[]|null
     */
    public $pluginTypes;

    /**
     * Lista de acciones permitidas.
     *
     * @var string|string[]|null
     */
    public $sandbox;

    /**
     * Etiqueta nonce para estilo
     */
    //public string $styleNonceTag = '';
    public string $styleNonceTag = '{csp-style-nonce}';

    /**
     * Etiqueta Nonce para guión
     */
    //public string $scriptNonceTag = '';
    public string $scriptNonceTag = '{csp-script-nonce}';

    /**
     * Reemplace la etiqueta Nonce automáticamente
     */
    public bool $autoNonce = false;
    //public bool $autoNonce = true;
}
