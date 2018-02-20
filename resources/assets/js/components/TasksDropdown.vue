<template>
    <div>
        <select name="task" id="task" class="form-control" :disabled="loading" v-model="taskid">
            <option v-for="task in tasks" :key="task.id" :value="task.id" >{{task.title}}</option>
        </select>
    </div>
</template>

<script>

    export default {
        props: ['currentproject', 'currenttask'],

        data() {
            return {
                tasks: [],
                tasksForLoading: [{ 'id': 0, 'title': "Loading tasks..." }],
                endpoint: '/api/tasks/p/',
                loading: true,
                projectid: this.currentproject,
                taskid: this.currenttask,
                currentTask: this.currenttask,
            };
        },

        created() {
            this.fetch(this.projectid);
        },

        methods: {
            fetch(projectid) {
                // Start loading
                this.tasks = [];
                this.taskid = 0;
                this.loading = true;

                axios.get(this.endpoint + projectid)
                    .then(({data}) => {

                        this.tasks = data;

                        // Check if Project contains selected task
                        var currentTask = this.currentTask;
                        var valObj = data.filter(function(elem){
                            if(elem.id == currentTask) return elem; 
                        });

                        if(valObj.length > 0) {
                            this.taskid = this.currentTask;
                        }
                        else {
                            this.taskid = data[0].id;
                        }

                        // Stop loading
                        this.loading = false;
                        this.$root.$emit('tasksdropdown.loading', false);
                    });
            },
        },

        mounted() {

            // Get tasks when project is selected
            this.$root.$on('projectsdropdown.changed', data => {
                this.fetch(data);
            });
        }
    }
</script>