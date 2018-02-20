<template>
    <div>
        <select name="project" id="project" class="form-control" v-model="projectid" @change="changedProject" :disabled="loading">
            <option v-for="project in projects" :key="project.id" :value="project.id" >{{project.title}}</option>
        </select>
    </div>
</template>


<script>

    export default {
        // Our Javascript logic

        props: ['currentproject'],

        data() {
            return {
                projects: [],
                endpoint: '/api/projects/',
                projectid: this.currentproject,
                currentProject: this.currentproject,
                loading: true,
            };
        },

        created() {
            this.fetch();
        },

        mounted() {
            this.$root.$on('tasksdropdown.loading', data => {
                this.loading = data;
            });
        },

        methods: {
            fetch() {
                // Start loading
                this.projects = [{ 'id': 0, 'title': "Loading projects..." }];
                this.projectid = 0;
                this.loading = true;

                // this.projectid = this.$parent.project;
                var currentProject = this.currentProject;
                // this.loading = true;

                axios.get(this.endpoint)
                    .then(({data}) => {
                        this.projects = data;
                        this.projectid = currentProject;

                        // this.changedProject();
                        this.loading = false;
                    });
            },
            changedProject() {
                this.loading = true;
                this.$root.$emit('projectsdropdown.changed', this.projectid);
            }
        },
    }
</script>