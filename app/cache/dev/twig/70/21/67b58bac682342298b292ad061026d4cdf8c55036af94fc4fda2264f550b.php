<?php

/* DictionaryBundle::layout.html.twig */
class __TwigTemplate_702167b58bac682342298b292ad061026d4cdf8c55036af94fc4fda2264f550b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'navigation' => array($this, 'block_navigation'),
            'content' => array($this, 'block_content'),
            'additionaljs' => array($this, 'block_additionaljs'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE >
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\" />
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />

    ";
        // line 8
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "e4e7197_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_e4e7197_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/min_bootstrap_1.css");
            // line 13
            echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
    ";
            // asset "e4e7197_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_e4e7197_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/min_part_2_main_1.css");
            echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
    ";
        } else {
            // asset "e4e7197"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_e4e7197") : $this->env->getExtension('assets')->getAssetUrl("_controller/css/min.css");
            echo "        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\" />
    ";
        }
        unset($context["asset_url"]);
        // line 15
        echo "</head>

<body>

    ";
        // line 19
        $this->displayBlock('navigation', $context, $blocks);
        // line 20
        echo "
    <div class='container'>
        ";
        // line 22
        $this->displayBlock('content', $context, $blocks);
        // line 24
        echo "    </div>

    ";
        // line 26
        if (isset($context['assetic']['debug']) && $context['assetic']['debug']) {
            // asset "04f3781_0"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_04f3781_0") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/min_part_1.js");
            // line 32
            echo "        <script type=\"text/javascript\" src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
            // asset "04f3781_1"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_04f3781_1") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/min_part_2.js");
            echo "        <script type=\"text/javascript\" src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        } else {
            // asset "04f3781"
            $context["asset_url"] = isset($context['assetic']['use_controller']) && $context['assetic']['use_controller'] ? $this->env->getExtension('routing')->getPath("_assetic_04f3781") : $this->env->getExtension('assets')->getAssetUrl("_controller/js/min.js");
            echo "        <script type=\"text/javascript\" src=\"";
            echo twig_escape_filter($this->env, (isset($context["asset_url"]) ? $context["asset_url"] : $this->getContext($context, "asset_url")), "html", null, true);
            echo "\"></script>
    ";
        }
        unset($context["asset_url"]);
        // line 34
        echo "
    ";
        // line 35
        $this->displayBlock('additionaljs', $context, $blocks);
        // line 37
        echo "</body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome!";
    }

    // line 19
    public function block_navigation($context, array $blocks = array())
    {
    }

    // line 22
    public function block_content($context, array $blocks = array())
    {
        // line 23
        echo "        ";
    }

    // line 35
    public function block_additionaljs($context, array $blocks = array())
    {
        // line 36
        echo "    ";
    }

    public function getTemplateName()
    {
        return "DictionaryBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 36,  132 => 35,  128 => 23,  125 => 22,  120 => 19,  114 => 5,  109 => 37,  107 => 35,  104 => 34,  84 => 32,  76 => 24,  74 => 22,  68 => 19,  42 => 13,  33 => 6,  23 => 1,  80 => 26,  75 => 24,  70 => 20,  62 => 15,  59 => 16,  53 => 14,  51 => 13,  45 => 10,  41 => 9,  38 => 8,  35 => 7,  29 => 5,);
    }
}
