<script>
    
    import axios from 'axios';
     
    export default {
        data() {
            return {
                server: 'http://localhost/api/',
                token: null,   
                
                n: null
            }
        },
        methods: {
            doRequests() {
                
                let headers = {
                'Authorization': `Bearer ${this.token}`
                };
               
                axios.post(`${this.server}activities/get-organizations-by-activity`,
                {
                    title: 'Еда'
                },
                {
                    headers: headers
                })
                .then(response => this.n = response.data.title)
                .catch(err => console.log(err.response.data.message));   


                 axios.post(`${this.server}activities/get-organizations-by-activity-type`,
                  {
                    title: 'Еда'
                  },
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.message));


                  axios.post(`${this.server}organizations/get-organization-by-name`,
                  {
                    title: 'Рога и копыта1'
                  },
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.message));

                 axios.get(`${this.server}organizations/get-organization-info-by-id/2`,
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.message));

              axios.get(`${this.server}buildings/get-organizations-by-building`,
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.errors));

                 axios.get(`${this.server}buildings/get-buildings-by-coords?latitude=35&longitude=54`,
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.errors));
            },

            async createToken() {
                let token = localStorage.token;    

                if(!token){
                    let response = await axios.post('http://localhost/api/tokens/create');
                    token = await response.data.token;
                    localStorage.token = token;
                }
                     
                this.token = token;
            }
        },
            async beforeMount() {
                await this.createToken();

                this.doRequests();
            }
    }
    
    
    
    
    
    
   
 
   
 

</script>

<template>
    
    
    {{n}}

</template>

<style>

</style>
