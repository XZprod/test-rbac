import UserEditForm from "./UserEditForm.js";

let component = {
    props: ['title'],
    template: `
<div>
<div v-for="group in groups">

<p>{{group.title}}</p>
<div v-for="role in roles">
{{role.title}}<input type="checkbox" v-bind:checked="isChecked(group, role)" :key="role.id" @click="update(group, role, isChecked(group, role))">
</div>
</div>
    </div>

    `,
    data: function () {
        return {
            roles: [],
            groups: [],
            roles_groups: []
        };

    },
    created() {
        this.updateRoles();
        this.updateGroups();
        this.updateRolesGroups();
    },

    methods: {

        updateRoles: function () {
            fetch('/json.php/get-roles')
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.roles = json;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        updateGroups: function () {
            fetch('/json.php/get-groups')
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.groups = json;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        updateRolesGroups: function () {
            fetch('/json.php/get-roles_groups')
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }

                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    this.roles_groups = json;
                    this.$forceUpdate();

                })
                .catch((error) => {
                    console.log(error);
                });
        },

        isChecked: function (group, role) {
            let res = false;
            this.roles_groups.forEach(function (element) {
                if (element.group_id == group.id && element.item_id == role.id) {
                    res = true;
                    return;
                }
            });
            return res;
        },

        update: function (group, role, isAllow) {
            axios.post('/json.php/update-role', {
                group_id: group.id,
                role_id: role.id,
                allow: !isAllow
            })
                .then(function (response) {
                    if (response.data.status == 'success') {
                        console.log('ok');
                    }
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
    computed: {},

};
export default component;