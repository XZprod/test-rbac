<?php

use App\Auth;
use App\User;

require __DIR__ . '/vendor/autoload.php';
?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/site.css">
</head>

<body>
<?php
if (!User::can(Auth::getUser(), 'canUseAdminpanel')) {
throw new Exception('Ошибка авторизации');
}
?>
<div id="app">
    <page-component>
        <div class="top-menu">
            <div class="menu-item-wrap" v-for="tab in tabs">
                <span
                        v-bind:key="tab.name"
                        v-bind:class="['tab-button', { active: currentTab.name === tab.name }]"
                        v-on:click="currentTab = tab"
                >{{ tab.name }}
            </span>
            </div>
            <div class="menu-item-wrap">
                <i class="fas fa-plus fa-lg" onClick="window.applic.$refs.currComp.create()"></i>
            </div>

        </div>

        <component
                v-bind:is="currentTab.component"
                class="tab"
                ref="currComp"
        ></component>
        <div id="user-edit-form"></div>
    </page-component>
</div>

<script src="https://ru.vuejs.org/js/vue.js"></script>
<script src="https://unpkg.com/vuex"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="js/main.js" type="module"></script>


</body>
</html>

