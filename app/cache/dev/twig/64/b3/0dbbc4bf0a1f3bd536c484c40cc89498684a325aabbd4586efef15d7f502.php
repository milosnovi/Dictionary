<?php

/* DictionaryBundle:Default:index.html.twig */
class __TwigTemplate_64b30dbbc4bf0a1f3bd536c484c40cc89498684a325aabbd4586efef15d7f502 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("DictionaryBundle::layout.html.twig");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "DictionaryBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session"), "flashbag"), "get", array(0 => "notice"), "method"));
        foreach ($context['_seq'] as $context["_key"] => $context["flashMessage"]) {
            // line 5
            echo "        <div class=\"flash-message\">
            <em>Notice</em>: ";
            // line 6
            echo twig_escape_filter($this->env, (isset($context["flashMessage"]) ? $context["flashMessage"] : $this->getContext($context, "flashMessage")), "html", null, true);
            echo "
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['flashMessage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 9
        echo "
    <form method=\"post\" action=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("_translate");
        echo "\" >
        <div class=\"form-row\">
            <input name=\"q\" id=\"search-id\" type=\"search\" placeholder=\"Translate\" />

            <button type=\"submit\" class=\"sf-button\">
                <span class=\"border-l\">
                    <span class=\"border-r\">
                        <span class=\"btn-bg\">OK</span>
                    </span>
                </span>
            </button>
        </div>
    </form>

    ";
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["histories"]) ? $context["histories"] : $this->getContext($context, "histories")));
        foreach ($context['_seq'] as $context["key"] => $context["history"]) {
            // line 25
            echo "        ";
            echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : $this->getContext($context, "key")), "html", null, true);
            echo ": ";
            echo twig_escape_filter($this->env, twig_slice($this->env, twig_join_filter((isset($context["history"]) ? $context["history"] : $this->getContext($context, "history")), ", "), 0, 110), "html", null, true);
            echo "<br/>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['history'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "
    <br>
    <br>
    <h1>MOST OFTEN</h1>
    ";
        // line 31
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["historyHits"]) ? $context["historyHits"] : $this->getContext($context, "historyHits")));
        foreach ($context['_seq'] as $context["key"] => $context["hit"]) {
            // line 32
            echo "        ";
            echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : $this->getContext($context, "key")), "html", null, true);
            echo ": ";
            echo twig_escape_filter($this->env, twig_slice($this->env, twig_join_filter($this->getAttribute((isset($context["hit"]) ? $context["hit"] : $this->getContext($context, "hit")), "translation"), ", "), 0, 110), "html", null, true);
            echo "<br/>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['hit'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 34
        echo "
";
    }

    public function getTemplateName()
    {
        return "DictionaryBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 34,  93 => 32,  89 => 31,  83 => 27,  72 => 25,  68 => 24,  51 => 10,  48 => 9,  39 => 6,  36 => 5,  31 => 4,  28 => 3,);
    }
}
