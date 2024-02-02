// app.js
new Vue({
    el: '#app',
    data: {
        horaInicio: '',
        horaFim: '',
        resultado: null
    },
    methods: {
        async calcularHoras() {
            const response = await fetch('calculadoraHoras.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    horaInicio: this.horaInicio,
                    horaFim: this.horaFim
                })
            });
            const data = await response.json();
            this.resultado = data;
        }
    }
});
