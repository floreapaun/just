<template>
  <div class="container">
    <div class="courts">
      <div class="form-row" v-for="(court, index) in courts" :key="index">
        <div class="form-group col-md-5">
          <label>Complet</label>
          <input v-model="court.name" type="text" class="form-control" placeholder="Complet">
        </div>
        <div class="form-group col-md-5">
          <label>Judecator</label>
          <input v-model="court.judge" type="text" class="form-control" placeholder="Judecator">
        </div>
        <div class="form-group col-md-1 text-center my-auto">
          <a href="#" @click="updateCourt(court.id, court.name, court.judge)">
            <i class="bi-arrow-repeat" style="font-size: 3rem; color: green;"></i>
          </a>
        </div>
        <div class="form-group col-md-1 text-center my-auto">
          <a href="#" @click="removeCourt(court.id)">
            <i class="bi-file-x" style="font-size: 3rem; color: red;"></i>
          </a>
        </div>
      </div>
      <div v-if="addIsClicked" class="form-row">
        <div class="form-group col-md-5">
          <label>Complet</label>
          <input v-model="newCourtName" type="text" class="form-control" placeholder="Complet">
        </div>
        <div class="form-group col-md-5">
          <label>Judecator</label>
          <input v-model="newCourtJudge" type="text" class="form-control" placeholder="Judecator">
        </div>
        <div class="form-group col-md-1 text-center my-auto">
          <a href="#" @click="insertCourt()">
            <i class="bi bi-plus-square" style="font-size: 3rem; color: blue;"></i>
          </a>
        </div>
        <div class="form-group col-md-1 text-center my-auto">
          <a href="#" @click="removeCourt()">
            <i class="bi-file-x" style="font-size: 3rem; color: red;"></i>
          </a>
        </div>
      </div>
      <div v-else class="form-row">
        <div class="form-group col-md-5">
        </div>
        <div class="form-group col-md-5">
        </div>
        <div class="form-group col-md-1 text-center my-auto">
          <a href="#" @click="addCourt()">
            <i class="bi bi-plus-square" style="font-size: 3rem; color: blue;"></i>
          </a>
        </div>
        <div class="form-group col-md-1 text-center my-auto">
        </div>
      </div>
    </div>
  </div>
</template>
<script>
let bootbox = require('bootbox');
export default {
  data: function() {
    return {
      addIsClicked: false,
      newCourtName: '',
      newCourtJudge: '',
      courts: [] 
    }
  },
  
  methods: {
    addCourt () {
      this.addIsClicked = true;
    },

    insertCourt() {
      let data = {
        'name': this.newCourtName,
        'judge': this.newCourtJudge,
      };
      axios.post('/api/court/store', data)
        .then( response => {

          console.log(response.data);
          if (response.data.success) {  

            bootbox.alert({
              title: "<i class='bi bi-check-circle-fill'></i><span>Confirmare</span>",
              message: "<p>Completul de judecata a fost adaugat.</p>"
            });

            //update the courts table 
            this.getCourts();
            
            this.addIsClicked = false;
            this.newCourtName = '';
            this.newCourtJudge = '';
   
          }
          else {
            if (response.data.reason === 'active') 
              bootbox.alert({
                title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
                message: "<p>Completul de judecata nu a fost adaugat. Exista complet cu acelasi nume.</p>"
              });
            else
              bootbox.alert({
                title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
                message: "<p>Completul de judecata nu a fost adaugat. A existat complet cu acelasi nume, acum inactiv.</p>"
              });
          }    
            
        }).catch( error => {
          console.log(error);
        });
    },

    updateCourt (id, name, judge) {
      let data = {
        'court_id': id,
        'name': name,
        'judge': judge,
      };
      axios.post('/api/court/update', data)
        .then( response => {
          console.log(response.data);
          if (response.data.success) 
            bootbox.alert({
              title: "<i class='bi bi-check-circle-fill'></i><span>Confirmare</span>",
              message: "<p>Completul de judecata a fost actualizat.</p>"
            });
          else {
            if (response.data.reason === 'active') 
              bootbox.alert({
                title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
                message: "<p>Completul de judecata nu a fost actualizat. Exista complet cu acelasi nume.</p>"
              });
            else if (response.data.reason === 'inactive')
              bootbox.alert({
                title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
                message: "<p>Completul de judecata nu a fost actualizat. A existat complet cu acelasi nume, acum inactiv.</p>"
              });
            else
              bootbox.alert({
                title: "<i class='bi bi-x-octagon-fill'></i><span>Eroare</span>",
                message: "<p>Completul de judecata nu a fost actualizat. Valorile campurilor sunt aceleasi.</p>"
              });
          }
        }).catch( error => {
          console.log(error);
        });
    },

    removeCourt (id) {
      if (id) {
        axios.post('/api/court/remove', { 'court_id': id })
          .then( response => {
            console.log(response.data);
            if (response.data.success)
              bootbox.alert({
                title: "<i class='bi bi-check-circle-fill'></i><span>Confirmare</span>",
                message: "<p>Completul de judecata a fost sters.</p>"
              });

            //update the courts table 
            this.getCourts();
          }).catch( error => {
            console.log(error);
          });
      }
      else 
        this.addIsClicked = false;
    },
    
    getCourts () {
      axios.post('/api/courts/index')
        .then( response => {
          this.courts = response.data;
          console.log(response.data);
        }).catch( error => {
          console.log(error);
        });
    }
      
  }, 

  mounted() {
	this.getCourts();
    console.log(this.courts);
  }
}
</script>
<style>
.bi.bi-check-circle-fill {
  margin-right: 3px; 
  font-size: 2rem; 
  color: green;
}
.bi.bi-x-octagon-fill {
  margin-right: 3px; 
  font-size: 2rem; 
  color: red;
}
.courts > div {
  margin: 20px 0;
  padding-bottom: 10px;
}
.courts > div:not(:last-child) {
  border-bottom: 1px solid rgb(206, 212, 218);
}
</style>
