import PageComponent from './PageComponent.js';
import RoleManagmentTab from './RoleManagmentTab.js';
import UserManagmentTab from './UserManagmentTab.js';

Vue.component('page-component', PageComponent);


let tabs = [
    {
        name: 'Действие',
        component: UserManagmentTab,
    },
    {
        name: 'Права',
        component: RoleManagmentTab
    }
];

 window.applic = new Vue({
    el: '#app',
    data: {
        message: 'Привет, Vue!',
        tabs: tabs,
        currentTab: tabs[0]
    },
});

