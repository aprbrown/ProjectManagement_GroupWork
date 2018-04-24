<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                editing: false,
                title: this.attributes.name,
                body: this.attributes.description,
                status: this.attributes.status,
                priority: this.attributes.priority,
                startDate: this.attributes.start_date,
                dueDate: this.attributes.due_date
            }
        },

        methods: {
            update() {
                axios.patch('/tasks/' + this.attributes.id, {
                    title: this.title,
                    body: this.body,
                    status: this.status,
                    priority: this.priority,
                    startDate: this.startDate,
                    dueDate: this.dueDate,
                });

                this.editing = false;

                flash('Updated');
            }
        }
    }
</script>