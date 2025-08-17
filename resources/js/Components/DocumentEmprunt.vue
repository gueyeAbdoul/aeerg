// resources/js/components/DocumentEmprunt.vue
export default {
    data() {
        return {
            documents: [],
            selectedDoc: null
        }
    },
    methods: {
        async emprunter() {
            try {
                const response = await axios.post('/api/emprunts', {
                    document_id: this.selectedDoc.id
                });
                this.$toast.success('Emprunt enregistré');
            } catch (error) {
                this.$toast.error(error.response.data.message);
            }
        }
    }
}
