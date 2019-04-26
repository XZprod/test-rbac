let component = {
    props: ['user'],
    template: `
<div id="user-edit-form">
<form action="#">
<input type="text" name="fullname" v-model="user.fullname"><br>
<select name="group_id" v-model="user.group_id">
    <option v-for="group in groups" v-bind:value="group.id" v-bind:selected="group.id === user.group_id">{{group.title}}</option><br>
</select><br>
<input type="text" name="phone"  v-model="user.phone"><br>
<input type="hidden" name="id" v-bind:value="user.id"><br>

<button v-on:click.stop.prevent @click="user.isNew ? createUser(user) : updateUser(user)">Обновить</button>

</form>
</div>`,
    data: function () {
        return {
            groups: []
        }
    },
    created() {
        this.updateList()
    },

    methods: {
        updateUser: function (user) {
            console.log(user);
            axios.post('/json.php/update-user', {
                fullname: user.fullname,
                id: user.id,
                phone: user.phone,
                group_id: user.group_id
            })
                .then(function (response) {
                    if (response.data.status == 'success') {
                        applic.$refs.currComp.updateList();

                    }
                    console.log(response.data.status);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        createUser: function (user) {
            console.log(user);
            axios.post('/json.php/create-user', {
                fullname: user.fullname,
                phone: user.phone,
                group_id: user.group_id
            })
                .then(function (response) {
                    if (response.data.status == 'success') {
                        applic.$refs.currComp.updateList();
                    }
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateList: function () {
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
        }
    }

};
export default component;