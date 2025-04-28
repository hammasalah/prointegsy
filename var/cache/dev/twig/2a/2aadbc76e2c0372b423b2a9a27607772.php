<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* base.html.twig */
class __TwigTemplate_21d2b47f1bec405fd2b29e4011d05257 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 2
        yield from $this->unwrap()->yieldBlock('stylesheets', $context, $blocks);
        // line 10
        yield "
";
        // line 11
        yield from $this->unwrap()->yieldBlock('body', $context, $blocks);
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    // line 2
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_stylesheets(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 3
        yield "    <!-- Google Fonts & Font Awesome -->
    <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css\">

    <!-- Your compiled CSS (from Symfony Encore) -->
    <link rel=\"stylesheet\" href=\"";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/root.css"), "html", null, true);
        yield "\">
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 11
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 12
        yield "<header class=\"header\">
    <nav class=\"nav-container\">
        <div class=\"logo\">
            <img src=\"";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/logo.svg"), "html", null, true);
        yield "\" alt=\"Connect Sphere\" class=\"logo-img\">
        </div>
        <div class=\"nav-links\">
            <a href=\"#\" class=\"nav-link\">About</a>
            <a href=\"#\" class=\"nav-link\">Events</a>
            <a href=\"#\" class=\"nav-link\">Speakers</a>
            <a href=\"#\" class=\"nav-link\">Tickets</a>
            <a href=\"#\" class=\"nav-link\">Blogs</a>
            <a href=\"#\" class=\"contact-btn nav-link\">Contact</a>
            <i class=\"fas fa-search\"></i>
        </div>
    </nav>
</header>

<main>
    ";
        // line 31
        yield "    <section class=\"hero\">
        <div class=\"hero-content\">
            <!-- Left Column: Text -->
            <div class=\"hero-text\">
                <!-- You can incorporate date/limited seats info here if desired -->
                <p class=\"event-date\" style=\"color: #F96358; font-weight: 600;\">
                    9 June 2023 | Limited Seats
                </p>
                <h1 class=\"hero-title\">
                    The Ultimate Platform for Planning and Promoting Successful Events
                </h1>
                <p class=\"hero-subtitle\">
                    Connect Sphere helps you create unforgettable experiences with our comprehensive event management tools.
                </p>
                <!-- Primary Call-to-Action -->
                <a href=\"#\" class=\"cta-btn\">Buy Tickets</a>
            </div>

            <!-- Right Column: Illustration/Image -->
            <div class=\"hero-illustration\">
                <!-- Replace with your actual hero image -->
                <img src=\"";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/hero-illustration.png"), "html", null, true);
        yield "\" alt=\"Hero Illustration\">
            </div>
        </div>

        ";
        // line 57
        yield "        <div class=\"social-icons\">
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-facebook\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-twitter\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-instagram\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-linkedin\"></i></a>
        </div>
    </section>

    ";
        // line 66
        yield "    <section class=\"section\">
        <h2 class=\"section-title\">WHO WE ARE</h2>
        <p class=\"section-subtitle\">
            We are a leading event management platform dedicated to helping you create exceptional experiences through innovative technology and expert support.
        </p>
        <div class=\"cards-grid\">
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-globe\"></i></div>
                <h3>Global Network</h3>
                <p>Connect with event professionals worldwide</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-tools\"></i></div>
                <h3>Advanced Tools</h3>
                <p>Powerful features for event management</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-palette\"></i></div>
                <h3>Customizable Pages</h3>
                <p>Create unique event pages easily</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-bullhorn\"></i></div>
                <h3>Powerful Marketing</h3>
                <p>Reach your target audience effectively</p>
            </div>
        </div>
    </section>
</main>

<footer class=\"footer\">
    <button class=\"contact-btn\">Contact Us</button>
</footer>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  175 => 66,  165 => 57,  158 => 52,  135 => 31,  117 => 15,  112 => 12,  99 => 11,  86 => 8,  79 => 3,  66 => 2,  55 => 11,  52 => 10,  50 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{# templates/pages/landing.html.twig #}
{% block stylesheets %}
    <!-- Google Fonts & Font Awesome -->
    <link href=\"https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css\">

    <!-- Your compiled CSS (from Symfony Encore) -->
    <link rel=\"stylesheet\" href=\"{{ asset('css/root.css') }}\">
{% endblock %}

{% block body %}
<header class=\"header\">
    <nav class=\"nav-container\">
        <div class=\"logo\">
            <img src=\"{{ asset('images/logo.svg') }}\" alt=\"Connect Sphere\" class=\"logo-img\">
        </div>
        <div class=\"nav-links\">
            <a href=\"#\" class=\"nav-link\">About</a>
            <a href=\"#\" class=\"nav-link\">Events</a>
            <a href=\"#\" class=\"nav-link\">Speakers</a>
            <a href=\"#\" class=\"nav-link\">Tickets</a>
            <a href=\"#\" class=\"nav-link\">Blogs</a>
            <a href=\"#\" class=\"contact-btn nav-link\">Contact</a>
            <i class=\"fas fa-search\"></i>
        </div>
    </nav>
</header>

<main>
    {# HERO SECTION #}
    <section class=\"hero\">
        <div class=\"hero-content\">
            <!-- Left Column: Text -->
            <div class=\"hero-text\">
                <!-- You can incorporate date/limited seats info here if desired -->
                <p class=\"event-date\" style=\"color: #F96358; font-weight: 600;\">
                    9 June 2023 | Limited Seats
                </p>
                <h1 class=\"hero-title\">
                    The Ultimate Platform for Planning and Promoting Successful Events
                </h1>
                <p class=\"hero-subtitle\">
                    Connect Sphere helps you create unforgettable experiences with our comprehensive event management tools.
                </p>
                <!-- Primary Call-to-Action -->
                <a href=\"#\" class=\"cta-btn\">Buy Tickets</a>
            </div>

            <!-- Right Column: Illustration/Image -->
            <div class=\"hero-illustration\">
                <!-- Replace with your actual hero image -->
                <img src=\"{{ asset('images/hero-illustration.png') }}\" alt=\"Hero Illustration\">
            </div>
        </div>

        {# Optional: Social Icons, absolutely positioned in hero #}
        <div class=\"social-icons\">
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-facebook\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-twitter\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-instagram\"></i></a>
            <a href=\"#\" class=\"social-icon\"><i class=\"fab fa-linkedin\"></i></a>
        </div>
    </section>

    {# WHO WE ARE SECTION #}
    <section class=\"section\">
        <h2 class=\"section-title\">WHO WE ARE</h2>
        <p class=\"section-subtitle\">
            We are a leading event management platform dedicated to helping you create exceptional experiences through innovative technology and expert support.
        </p>
        <div class=\"cards-grid\">
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-globe\"></i></div>
                <h3>Global Network</h3>
                <p>Connect with event professionals worldwide</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-tools\"></i></div>
                <h3>Advanced Tools</h3>
                <p>Powerful features for event management</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-palette\"></i></div>
                <h3>Customizable Pages</h3>
                <p>Create unique event pages easily</p>
            </div>
            <div class=\"card\">
                <div class=\"card-icon\"><i class=\"fas fa-bullhorn\"></i></div>
                <h3>Powerful Marketing</h3>
                <p>Reach your target audience effectively</p>
            </div>
        </div>
    </section>
</main>

<footer class=\"footer\">
    <button class=\"contact-btn\">Contact Us</button>
</footer>
{% endblock %}
", "base.html.twig", "D:\\symphony_workspace\\prointegsy\\templates\\base.html.twig");
    }
}
