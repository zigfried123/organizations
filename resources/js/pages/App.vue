<script>
    
    import axios from 'axios';
     
    export default {
        data() {
            return {
                server: 'http://localhost/api/',
                token: null,   
            }
        },
        methods: {
            doRequests() {
                
                let headers = {
                'Authorization': `Bearer ${this.token}`
                };
               
                axios.get(`${this.server}activities/get-organizations-by-activity`,{headers: headers})
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.message));   


                 axios.post(`${this.server}activities/get-organizations-by-activity-type`,
                  {
                    title: 'Легковые'
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

                 axios.get(`${this.server}organizations/get-organization-info-by-id/9`,
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.message));

              axios.get(`${this.server}buildings/get-organization-by-building`,
                  {
                   headers: headers
                  })
                .then(response => console.log(response))
                .catch(err => console.log(err.response.data.errors));

                 axios.get(`${this.server}buildings/get-buildings-by-coords?latitude=1&longitude=2`,
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

</template>

<style>

</style>
