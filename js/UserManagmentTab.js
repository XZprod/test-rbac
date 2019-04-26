import UserEditForm from './UserEditForm.js';

let component = {
    template: `
<div>
    <table class="users-table">
        <col width="10%">
        <col width="20%">
        <col width="20%">
        <col width="15%">
        <col width="15%">
        <col width="5%">
        <col width="5%">
        <tr v-for="user in users">
            <td>{{user.fullname}}</td>
            <td>{{user.group_name}}</td>
            <td>{{user.phone}}</td>
            <td>{{user.time1}}</td>
            <td>{{user.time2}}</td>
            <td class="ar"><i class="fas fa-pencil-alt fa-lg" v-bind:id="user.id" @click="editUser(user)"></i></td>
            <td class="ar"><i class="fas fa-times fa-lg"  v-bind:id="user.id" @click="deleteUser(user)"></i></td>
        </tr>
    </table>
</div>`,
    data: function () {
        return {
            users: [],
        };

    },
    created() {
        this.updateList()
    },

    methods: {
        editUser: function (user) {
            const ComponentCtor = Vue.extend(UserEditForm);
            const copyUser = Object.assign({}, user);
            const componentInstance = new ComponentCtor({propsData: {user: copyUser}});

            componentInstance.$mount('#user-edit-form')
        },

        create: function () {
            const ComponentCtor = Vue.extend(UserEditForm);
            const componentInstance = new ComponentCtor({propsData: {user: {isNew: true}}});

            componentInstance.$mount('#user-edit-form')
        },

        deleteUser: function (user) {
            let context = this;
            axios.post('/json.php/delete-user', {
                id: user.id,
            })
                .then(function (response) {
                    if (response.data.status == 'success') {
                        this.updateList();

                    }
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateList: function () {
            fetch('/json.php/get-users')
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.users = json;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
};
export default component;