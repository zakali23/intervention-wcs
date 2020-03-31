const app = new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data() {
        return {
            search: '',
            users: [],
            user: {
                lastName: null,
                firstName: null,
                address: null,
                zipCode: null,
                city: null,
                address2: null
            },
            editShow: false,
            saveShow: true

        }
    },
    mounted() {
       //Show all users
        return this.fetchAllUsers()
    },
    watch: {
        search(val) {
            // watcher value search
            this.searchUserByName(val)
        }
    },
    methods: {
        fetchAllUsers() {
            // method for fetch all users with axios promise http
            axios.get('http://localhost:8000/users').then(res => {
                this.users = res.data

            })
        },
        addUser() {
            // add user    
            const formData = new FormData();
            formData.append('user', JSON.stringify(this.user));
            const url = "http://localhost:8000/user/add"
            axios.post(
                    url,
                    formData
                ).then(res => {
                    console.log(res)
                    UIkit.notification("<span uk-icon='icon: check'></span>User has been successfully created ", {
                        status: 'success'
                    })
                    UIkit.modal('#modal-sections').hide();
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(
                    () => {
                        return this.fetchAllUsers()
                    }
                )

        },
        reset() {
            this.user = {
                lastName: null,
                firstName: null,
                address: null,
                zipCode: null,
                city: null,
                address2: null
            }
            this.editShow = false
            this.saveShow = true

        },
        editUser(user) {
            // show form edit 
            UIkit.modal('#modal-sections').show();
            this.user = user;
            this.editShow = true
            this.saveShow = false
        },

        validEdit() {
            // edit user by id
            const formData = new FormData();
            formData.append('user', JSON.stringify(this.user));
            const url = 'http://localhost:8000/user/' + this.user.id;
            axios.post(url, formData).then((res) => {
                    UIkit.notification("<span uk-icon='icon: check'></span>" + res.data, {
                        status: 'warning'
                    });
                    UIkit.modal('#modal-sections').hide();
                })
                .catch(err => {
                    console.log(err)
                })
                .finally(() => {
                    return this.fetchAllUsers()
                })
        },
        deleteUser(id) {
            // delete user by id
            const url = 'http://localhost:8000/user/' + id
            axios.get(url).then(res => {
                    console.log(res.data)
                    UIkit.notification("<span uk-icon='icon: check'></span>" + res.data, {
                        status: 'danger'
                    })
                })
                .catch(err => {

                })
                .finally(() => {
                    return this.fetchAllUsers()
                })
        },
        searchUserByName(search) {
            // search user by name
            if (search) {
                const url = "http://localhost:8000/find/" + search;
                axios.get(url).then(res => {
                    const items = res.data.data
                    this.users = res.data.data
                }).catch(err => {
                    console.log(err)
                })
            } else {
                this.fetchAllUsers()
            }
        }
    },
})