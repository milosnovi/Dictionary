<?php

/* WebProfilerBundle:Profiler:info.html.twig */
class __TwigTemplate_3a7ac652d6cb27407b3d739dab9bbeb29d42b706611023334b664ca34f3b8e68 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("@WebProfiler/Profiler/base.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"content\">
        ";
        // line 5
        $this->env->loadTemplate("@WebProfiler/Profiler/header.html.twig")->display(array());
        // line 6
        echo "
        <div id=\"main\">
            <div class=\"clear-fix\">
                <div id=\"collector-wrapper\">
                    <div id=\"collector-content\">
                        ";
        // line 11
        $this->displayBlock('panel', $context, $blocks);
        // line 34
        echo "                    </div>
                </div>
                <div id=\"navigation\">
                    ";
        // line 37
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_search_bar"));
        echo "
                    ";
        // line 38
        $this->env->loadTemplate("@WebProfiler/Profiler/admin.html.twig")->display(array("token" => ""));
        // line 39
        echo "                </div>
            </div>
        </div>
    </div>
";
    }

    // line 11
    public function block_panel($context, array $blocks = array())
    {
        // line 12
        echo "                            ";
        if (((isset($context["about"]) ? $context["about"] : $this->getContext($context, "about")) == "purge")) {
            // line 13
            echo "                                <h2>The profiler database was purged successfully</h2>
                                <p>
                                    <em>Now you need to browse some pages with the Symfony Profiler enabled to collect data.</em>
                                </p>
                            ";
        } elseif (((isset($context["about"]) ? $context["about"] : $this->getContext($context, "about")) == "upload_error")) {
            // line 18
            echo "                                <h2>A problem occurred when uploading the data</h2>
                                <p>
                                    <em>No file given or the file was not uploaded successfully.</em>
                                </p>
                            ";
        } elseif (((isset($context["about"]) ? $context["about"] : $this->getContext($context, "about")) == "already_exists")) {
            // line 23
            echo "                                <h2>A problem occurred when uploading the data</h2>
                                <p>
                                    <em>The token already exists in the database.</em>
                                </p>
                            ";
        } elseif (((isset($context["about"]) ? $context["about"] : $this->getContext($context, "about")) == "no_token")) {
            // line 28
            echo "                                <h2>Token not found</h2>
                                <p>
                                    <em>Token \"";
            // line 30
            echo twig_escape_filter($this->env, (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")), "html", null, true);
            echo "\" was not found in the database.</em>
                                </p>
                            ";
        }
        // line 33
        echo "                        ";
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  792 => 488,  775 => 485,  727 => 476,  710 => 475,  694 => 470,  679 => 466,  677 => 465,  660 => 464,  634 => 456,  625 => 453,  606 => 449,  601 => 446,  549 => 411,  532 => 410,  517 => 404,  202 => 94,  386 => 159,  378 => 157,  367 => 155,  331 => 140,  288 => 118,  184 => 63,  127 => 35,  333 => 115,  308 => 109,  234 => 90,  152 => 46,  1077 => 657,  1073 => 656,  1069 => 654,  1021 => 631,  1018 => 630,  1013 => 627,  1004 => 624,  1000 => 623,  997 => 622,  993 => 621,  984 => 615,  972 => 608,  970 => 607,  959 => 602,  947 => 597,  941 => 595,  937 => 593,  935 => 592,  926 => 589,  923 => 588,  919 => 587,  911 => 581,  909 => 580,  905 => 579,  896 => 573,  893 => 572,  874 => 562,  870 => 560,  864 => 558,  862 => 557,  844 => 546,  838 => 544,  828 => 538,  807 => 491,  800 => 523,  790 => 519,  788 => 486,  780 => 513,  770 => 507,  764 => 505,  762 => 504,  740 => 491,  724 => 484,  718 => 482,  705 => 480,  702 => 472,  686 => 468,  682 => 467,  664 => 463,  655 => 457,  646 => 451,  642 => 449,  626 => 443,  622 => 452,  603 => 439,  578 => 432,  563 => 429,  546 => 423,  542 => 421,  530 => 417,  527 => 408,  514 => 415,  293 => 120,  280 => 194,  249 => 92,  167 => 71,  462 => 202,  441 => 196,  422 => 184,  401 => 172,  338 => 116,  325 => 129,  320 => 127,  315 => 131,  303 => 122,  267 => 101,  262 => 93,  226 => 84,  216 => 79,  197 => 69,  211 => 56,  137 => 33,  77 => 20,  516 => 3,  512 => 2,  501 => 1,  491 => 186,  481 => 184,  476 => 180,  460 => 174,  454 => 172,  449 => 198,  419 => 158,  415 => 180,  403 => 149,  395 => 135,  376 => 133,  371 => 156,  369 => 128,  366 => 125,  363 => 153,  361 => 152,  358 => 151,  356 => 122,  353 => 149,  351 => 141,  348 => 140,  343 => 146,  336 => 107,  313 => 110,  296 => 121,  206 => 54,  192 => 50,  174 => 74,  1080 => 340,  1074 => 338,  1068 => 336,  1066 => 335,  1060 => 333,  1051 => 647,  1048 => 646,  1036 => 326,  1030 => 324,  1024 => 322,  1022 => 321,  1016 => 319,  1010 => 318,  1007 => 317,  995 => 312,  989 => 310,  983 => 308,  979 => 306,  975 => 609,  971 => 304,  967 => 606,  963 => 604,  957 => 301,  954 => 300,  946 => 296,  942 => 295,  939 => 294,  930 => 590,  928 => 286,  924 => 285,  921 => 284,  916 => 280,  904 => 277,  902 => 276,  900 => 275,  897 => 274,  891 => 571,  888 => 570,  884 => 568,  881 => 265,  879 => 264,  876 => 263,  869 => 259,  867 => 258,  843 => 257,  840 => 255,  837 => 253,  835 => 252,  830 => 539,  826 => 247,  815 => 531,  812 => 530,  808 => 235,  806 => 234,  797 => 229,  795 => 228,  793 => 227,  791 => 226,  786 => 224,  782 => 221,  779 => 216,  774 => 509,  751 => 206,  748 => 205,  745 => 493,  742 => 492,  739 => 200,  737 => 490,  732 => 487,  728 => 192,  726 => 191,  719 => 187,  717 => 186,  704 => 182,  701 => 180,  699 => 179,  692 => 474,  683 => 170,  671 => 465,  663 => 160,  661 => 159,  658 => 158,  654 => 155,  652 => 154,  645 => 150,  643 => 149,  640 => 448,  633 => 144,  629 => 454,  627 => 140,  624 => 139,  620 => 451,  617 => 135,  614 => 133,  609 => 129,  599 => 128,  592 => 126,  589 => 124,  587 => 434,  584 => 122,  579 => 118,  576 => 115,  575 => 114,  570 => 112,  567 => 414,  554 => 103,  552 => 102,  550 => 101,  544 => 99,  541 => 97,  539 => 96,  536 => 419,  522 => 406,  519 => 91,  502 => 87,  477 => 82,  472 => 79,  465 => 77,  463 => 175,  446 => 197,  443 => 74,  425 => 64,  421 => 62,  412 => 60,  410 => 59,  397 => 55,  394 => 168,  389 => 160,  383 => 49,  373 => 156,  370 => 45,  349 => 34,  346 => 33,  339 => 108,  334 => 141,  330 => 103,  328 => 139,  326 => 138,  323 => 128,  321 => 135,  300 => 121,  295 => 11,  290 => 119,  287 => 93,  282 => 90,  275 => 105,  270 => 102,  265 => 105,  263 => 294,  260 => 293,  257 => 291,  255 => 101,  250 => 274,  245 => 73,  242 => 269,  237 => 91,  232 => 88,  222 => 83,  212 => 59,  207 => 76,  194 => 68,  191 => 67,  181 => 65,  161 => 58,  129 => 122,  124 => 27,  2767 => 862,  2758 => 861,  2756 => 860,  2753 => 859,  2735 => 855,  2728 => 854,  2725 => 853,  2722 => 852,  2719 => 851,  2716 => 850,  2714 => 849,  2711 => 848,  2687 => 844,  2662 => 843,  2660 => 842,  2657 => 841,  2645 => 836,  2642 => 835,  2639 => 834,  2636 => 833,  2633 => 832,  2630 => 831,  2627 => 830,  2624 => 829,  2621 => 828,  2618 => 827,  2615 => 826,  2612 => 825,  2609 => 824,  2606 => 823,  2603 => 822,  2600 => 821,  2597 => 820,  2592 => 819,  2590 => 818,  2587 => 817,  2578 => 811,  2572 => 809,  2569 => 808,  2564 => 807,  2562 => 806,  2559 => 805,  2553 => 801,  2549 => 799,  2547 => 798,  2544 => 797,  2535 => 795,  2531 => 794,  2524 => 793,  2520 => 791,  2517 => 790,  2515 => 789,  2512 => 788,  2509 => 787,  2506 => 786,  2504 => 785,  2501 => 784,  2498 => 783,  2495 => 782,  2493 => 781,  2490 => 780,  2482 => 776,  2479 => 775,  2476 => 774,  2473 => 773,  2465 => 769,  2463 => 768,  2460 => 767,  2451 => 762,  2448 => 761,  2442 => 759,  2439 => 758,  2433 => 756,  2430 => 755,  2424 => 753,  2421 => 752,  2415 => 750,  2413 => 749,  2410 => 748,  2404 => 746,  2401 => 745,  2399 => 744,  2396 => 743,  2387 => 738,  2385 => 737,  2361 => 736,  2358 => 735,  2355 => 734,  2352 => 733,  2350 => 732,  2347 => 731,  2341 => 729,  2339 => 728,  2336 => 727,  2330 => 725,  2328 => 724,  2325 => 723,  2319 => 721,  2317 => 720,  2314 => 719,  2308 => 717,  2306 => 716,  2303 => 715,  2297 => 713,  2294 => 712,  2292 => 711,  2289 => 710,  2286 => 709,  2283 => 708,  2280 => 707,  2277 => 706,  2274 => 705,  2271 => 704,  2269 => 703,  2266 => 702,  2259 => 698,  2255 => 697,  2250 => 696,  2248 => 695,  2245 => 694,  2238 => 689,  2235 => 688,  2228 => 685,  2225 => 684,  2217 => 678,  2215 => 677,  2210 => 675,  2207 => 674,  2196 => 672,  2193 => 671,  2191 => 670,  2188 => 669,  2185 => 668,  2183 => 667,  2180 => 666,  2177 => 665,  2174 => 664,  2171 => 663,  2168 => 662,  2165 => 661,  2162 => 660,  2159 => 659,  2156 => 658,  2153 => 657,  2150 => 656,  2147 => 655,  2145 => 654,  2142 => 653,  2139 => 652,  2136 => 651,  2134 => 650,  2131 => 649,  2122 => 644,  2119 => 643,  2116 => 642,  2113 => 641,  2110 => 640,  2107 => 639,  2105 => 638,  2102 => 637,  2093 => 632,  2089 => 630,  2083 => 628,  2081 => 627,  2076 => 626,  2070 => 624,  2068 => 623,  2063 => 622,  2060 => 621,  2057 => 620,  2054 => 619,  2051 => 618,  2048 => 617,  2045 => 616,  2042 => 615,  2039 => 614,  2036 => 613,  2033 => 612,  2030 => 611,  2027 => 610,  2025 => 609,  2022 => 608,  2015 => 604,  2011 => 602,  2006 => 600,  2002 => 599,  1998 => 598,  1993 => 597,  1987 => 594,  1983 => 593,  1979 => 592,  1973 => 591,  1968 => 590,  1966 => 589,  1960 => 588,  1957 => 587,  1954 => 586,  1952 => 585,  1949 => 584,  1946 => 583,  1943 => 582,  1940 => 581,  1937 => 580,  1934 => 579,  1931 => 578,  1928 => 577,  1925 => 576,  1922 => 575,  1919 => 574,  1916 => 573,  1914 => 572,  1911 => 571,  1908 => 570,  1905 => 569,  1903 => 568,  1900 => 567,  1892 => 563,  1890 => 559,  1888 => 558,  1885 => 557,  1880 => 553,  1858 => 548,  1855 => 547,  1852 => 546,  1849 => 545,  1846 => 544,  1843 => 543,  1840 => 542,  1837 => 541,  1834 => 540,  1832 => 539,  1829 => 538,  1826 => 537,  1823 => 536,  1820 => 535,  1817 => 534,  1814 => 533,  1812 => 532,  1809 => 531,  1806 => 530,  1803 => 529,  1801 => 528,  1798 => 527,  1795 => 526,  1792 => 525,  1790 => 524,  1787 => 523,  1784 => 522,  1781 => 521,  1778 => 520,  1775 => 519,  1772 => 518,  1769 => 517,  1766 => 516,  1763 => 515,  1761 => 514,  1758 => 513,  1755 => 512,  1753 => 511,  1750 => 510,  1742 => 505,  1738 => 504,  1733 => 503,  1730 => 502,  1722 => 498,  1719 => 497,  1717 => 496,  1714 => 495,  1706 => 491,  1703 => 490,  1701 => 489,  1698 => 488,  1683 => 484,  1680 => 483,  1677 => 482,  1674 => 481,  1671 => 480,  1668 => 479,  1665 => 478,  1662 => 477,  1659 => 476,  1657 => 475,  1654 => 474,  1646 => 470,  1643 => 469,  1641 => 468,  1638 => 467,  1630 => 463,  1627 => 462,  1625 => 461,  1622 => 460,  1614 => 456,  1611 => 455,  1609 => 454,  1606 => 453,  1597 => 447,  1594 => 446,  1591 => 445,  1589 => 444,  1586 => 443,  1578 => 439,  1575 => 438,  1573 => 437,  1570 => 436,  1562 => 432,  1559 => 431,  1557 => 430,  1554 => 429,  1547 => 424,  1545 => 420,  1542 => 419,  1540 => 418,  1537 => 417,  1529 => 413,  1526 => 412,  1524 => 411,  1521 => 410,  1513 => 406,  1510 => 405,  1508 => 404,  1506 => 403,  1503 => 402,  1496 => 397,  1490 => 396,  1485 => 395,  1481 => 394,  1476 => 393,  1473 => 392,  1470 => 391,  1464 => 389,  1461 => 388,  1459 => 387,  1456 => 386,  1448 => 380,  1446 => 379,  1445 => 378,  1444 => 377,  1443 => 376,  1438 => 375,  1435 => 374,  1429 => 372,  1426 => 371,  1424 => 370,  1421 => 369,  1412 => 363,  1408 => 362,  1404 => 361,  1400 => 360,  1395 => 359,  1392 => 358,  1386 => 356,  1383 => 355,  1381 => 354,  1378 => 353,  1362 => 349,  1360 => 348,  1357 => 347,  1341 => 343,  1339 => 342,  1336 => 341,  1329 => 336,  1324 => 333,  1322 => 332,  1316 => 330,  1310 => 328,  1304 => 325,  1300 => 324,  1284 => 323,  1281 => 322,  1278 => 321,  1275 => 320,  1272 => 319,  1269 => 318,  1266 => 317,  1263 => 316,  1260 => 315,  1257 => 314,  1255 => 313,  1251 => 311,  1243 => 309,  1238 => 307,  1231 => 306,  1228 => 305,  1225 => 304,  1222 => 303,  1220 => 302,  1217 => 301,  1214 => 300,  1211 => 299,  1208 => 298,  1205 => 297,  1202 => 296,  1199 => 295,  1196 => 294,  1193 => 293,  1191 => 292,  1188 => 291,  1186 => 290,  1183 => 289,  1180 => 288,  1178 => 287,  1175 => 286,  1168 => 282,  1165 => 281,  1161 => 279,  1156 => 276,  1154 => 275,  1148 => 273,  1142 => 271,  1136 => 268,  1132 => 267,  1116 => 266,  1113 => 265,  1110 => 264,  1107 => 263,  1104 => 262,  1101 => 261,  1098 => 260,  1095 => 259,  1092 => 258,  1089 => 257,  1087 => 256,  1084 => 255,  1076 => 253,  1071 => 251,  1064 => 651,  1061 => 249,  1058 => 248,  1055 => 648,  1052 => 246,  1050 => 245,  1047 => 244,  1044 => 645,  1041 => 242,  1038 => 241,  1035 => 639,  1032 => 239,  1029 => 238,  1026 => 633,  1023 => 632,  1020 => 320,  1017 => 234,  1014 => 233,  1012 => 232,  1009 => 231,  1006 => 230,  1003 => 229,  1001 => 228,  998 => 227,  981 => 307,  969 => 221,  962 => 218,  960 => 217,  955 => 600,  952 => 215,  934 => 214,  932 => 213,  929 => 212,  920 => 207,  917 => 206,  914 => 205,  908 => 278,  906 => 202,  901 => 201,  898 => 200,  895 => 199,  880 => 566,  878 => 196,  871 => 195,  868 => 194,  865 => 193,  863 => 192,  860 => 191,  854 => 552,  848 => 548,  842 => 184,  836 => 543,  833 => 251,  829 => 180,  824 => 537,  822 => 245,  819 => 244,  810 => 492,  804 => 233,  801 => 232,  799 => 168,  796 => 489,  789 => 225,  787 => 161,  776 => 159,  773 => 158,  765 => 156,  763 => 155,  760 => 154,  757 => 153,  754 => 499,  752 => 151,  749 => 479,  746 => 478,  743 => 148,  741 => 147,  738 => 146,  735 => 198,  733 => 144,  730 => 143,  723 => 190,  721 => 137,  714 => 185,  711 => 134,  709 => 133,  706 => 473,  698 => 471,  696 => 476,  693 => 128,  690 => 469,  687 => 173,  684 => 125,  681 => 169,  678 => 468,  676 => 467,  673 => 165,  670 => 120,  668 => 464,  665 => 118,  659 => 114,  649 => 462,  647 => 111,  644 => 110,  636 => 446,  628 => 444,  623 => 103,  621 => 102,  616 => 440,  612 => 99,  608 => 98,  604 => 96,  600 => 95,  594 => 127,  591 => 436,  588 => 91,  586 => 90,  583 => 89,  580 => 88,  577 => 116,  574 => 431,  571 => 85,  568 => 84,  565 => 430,  562 => 108,  559 => 427,  556 => 104,  553 => 425,  551 => 424,  548 => 100,  540 => 73,  537 => 72,  534 => 418,  531 => 70,  529 => 409,  526 => 68,  518 => 4,  513 => 62,  507 => 60,  505 => 88,  500 => 58,  498 => 57,  495 => 56,  488 => 51,  486 => 50,  473 => 179,  470 => 78,  467 => 46,  464 => 45,  458 => 43,  455 => 42,  452 => 171,  450 => 40,  447 => 39,  442 => 37,  439 => 195,  431 => 189,  429 => 188,  426 => 32,  420 => 30,  417 => 143,  414 => 28,  411 => 140,  408 => 176,  405 => 137,  399 => 147,  396 => 22,  391 => 143,  388 => 134,  385 => 18,  382 => 131,  380 => 158,  377 => 129,  359 => 123,  357 => 37,  354 => 5,  350 => 120,  347 => 119,  345 => 147,  342 => 137,  340 => 145,  335 => 134,  332 => 104,  329 => 131,  327 => 805,  324 => 112,  319 => 779,  317 => 17,  307 => 128,  304 => 742,  302 => 125,  299 => 701,  297 => 200,  291 => 96,  289 => 196,  286 => 112,  284 => 684,  281 => 114,  279 => 649,  276 => 111,  274 => 110,  271 => 190,  266 => 607,  261 => 566,  259 => 103,  256 => 96,  253 => 100,  251 => 182,  248 => 97,  233 => 87,  228 => 65,  225 => 60,  223 => 63,  218 => 61,  215 => 60,  213 => 78,  210 => 77,  205 => 452,  200 => 72,  198 => 54,  195 => 53,  188 => 90,  185 => 75,  178 => 59,  175 => 58,  170 => 84,  165 => 83,  160 => 352,  155 => 47,  153 => 77,  148 => 286,  14 => 1,  113 => 48,  65 => 11,  190 => 49,  186 => 72,  180 => 70,  172 => 57,  150 => 55,  146 => 147,  134 => 39,  126 => 121,  118 => 49,  110 => 21,  90 => 42,  34 => 5,  53 => 12,  100 => 67,  81 => 23,  58 => 25,  20 => 1,  114 => 36,  84 => 40,  76 => 34,  70 => 15,  23 => 4,  104 => 31,  480 => 162,  474 => 80,  469 => 158,  461 => 44,  457 => 173,  453 => 199,  444 => 38,  440 => 148,  437 => 168,  435 => 69,  430 => 144,  427 => 162,  423 => 160,  413 => 155,  409 => 132,  407 => 138,  402 => 58,  398 => 136,  393 => 21,  387 => 164,  384 => 132,  381 => 137,  379 => 136,  374 => 128,  368 => 126,  365 => 125,  362 => 124,  360 => 38,  355 => 150,  341 => 117,  337 => 27,  322 => 780,  314 => 16,  312 => 130,  309 => 129,  305 => 108,  298 => 120,  294 => 98,  285 => 100,  283 => 115,  278 => 106,  268 => 83,  264 => 567,  258 => 187,  252 => 283,  247 => 273,  241 => 93,  229 => 87,  220 => 81,  214 => 231,  177 => 69,  169 => 168,  140 => 34,  132 => 35,  128 => 42,  107 => 35,  61 => 12,  273 => 85,  269 => 107,  254 => 92,  243 => 72,  240 => 71,  238 => 502,  235 => 89,  230 => 244,  227 => 86,  224 => 241,  221 => 80,  219 => 58,  217 => 232,  208 => 76,  204 => 75,  179 => 69,  159 => 57,  143 => 227,  135 => 46,  119 => 40,  102 => 33,  71 => 13,  67 => 14,  63 => 18,  59 => 16,  38 => 18,  94 => 21,  89 => 19,  85 => 23,  75 => 18,  68 => 12,  56 => 89,  87 => 41,  21 => 2,  26 => 4,  93 => 27,  88 => 24,  78 => 18,  46 => 34,  27 => 7,  44 => 11,  31 => 8,  28 => 3,  201 => 74,  196 => 92,  183 => 71,  171 => 73,  166 => 54,  163 => 82,  158 => 80,  156 => 58,  151 => 152,  142 => 35,  138 => 47,  136 => 71,  121 => 50,  117 => 37,  105 => 25,  91 => 25,  62 => 27,  49 => 14,  24 => 3,  25 => 4,  19 => 1,  79 => 18,  72 => 17,  69 => 16,  47 => 21,  40 => 9,  37 => 6,  22 => 3,  246 => 136,  157 => 56,  145 => 74,  139 => 34,  131 => 31,  123 => 61,  120 => 31,  115 => 23,  111 => 47,  108 => 33,  101 => 30,  98 => 45,  96 => 30,  83 => 33,  74 => 16,  66 => 167,  55 => 38,  52 => 12,  50 => 22,  43 => 12,  41 => 19,  35 => 5,  32 => 4,  29 => 3,  209 => 55,  203 => 73,  199 => 93,  193 => 429,  189 => 66,  187 => 48,  182 => 87,  176 => 86,  173 => 85,  168 => 61,  164 => 70,  162 => 59,  154 => 153,  149 => 148,  147 => 75,  144 => 42,  141 => 73,  133 => 45,  130 => 46,  125 => 41,  122 => 26,  116 => 57,  112 => 22,  109 => 52,  106 => 51,  103 => 23,  99 => 23,  95 => 27,  92 => 28,  86 => 185,  82 => 19,  80 => 27,  73 => 33,  64 => 13,  60 => 22,  57 => 39,  54 => 82,  51 => 37,  48 => 16,  45 => 9,  42 => 11,  39 => 10,  36 => 10,  33 => 9,  30 => 5,);
    }
}
