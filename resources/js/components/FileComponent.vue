<template>
  <div class="container">
    <form>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Nr. unic (nr. format vechi)</label>
        </div>
        <div class="form-group col-md-6">
          <input v-model="fileNumber" type="text" class="form-control" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Sectie</label>
        </div>
        <div class="form-group col-md-6">
          <input type="text" class="form-control" placeholder="Sectia Penala" disabled>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label>Materie</label>
        </div>
        <div class="form-group col-md-6">
          <input type="text" class="form-control" placeholder="Penal" disabled>
        </div>
      </div>

      <h2>Obiecte</h2>
      <div class="crimes">	
        <div v-for="(crime, index) in file.crimes" :key="index" class="form-row">
          <div class="form-group col-md-6 my-auto">
            <select v-model="crime.name" disabled>
              <option v-for="c in crimesList">{{ c.name }}</option>
            </select>
          </div>
        </div>
      </div>
 
      <hr>

      <h2>Parti</h2>
      <div class="parts">
        <div class="form-row" v-for="(part, index) in file.parts" :key="index">
          <div class="form-group col-md-6">
            <label>Nume</label>
            <input v-model="part.name" :name="`parts[${index}][name]`" type="text" class="form-control" placeholder="Nume" disabled>
          </div>
          <div class="form-group col-md-6">
            <label>Calitate parte</label>
            <select v-model="part.type" class="form-control" disabled>
              <option>Inculpat</option>
              <option>Parte civila</option>
              <option>Parte vatamata</option>
              <option>Parte responsabila civilmente</option>
            </select>
          </div>
        </div>
      </div>
      <h1>Sedinte</h1>
      <div class="trials">
        <div v-for="(trial, index) in file.trials" :key="index">
        
          <!-- start continued -->
          <div v-if="trial.type === 'continued'">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Termen de judecata</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" value="Amanare cauza" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Tip solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.solution" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Document</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.document" class="form-control" disabled>
              </div>
            </div>
          </div>
          <!-- end continued -->

          <!-- start ended -->  
          <div v-if="trial.type === 'ended'">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Termen de judecata</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" value="Hotarare" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Tip solutie</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.solution" class="form-control" disabled>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Document</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" v-model="trial.document" class="form-control" disabled>
              </div>
            </div>
            
            <hr>
        
            <h2>Cai atac</h2>
            <div v-if="hasRevoke">
              <table>
                <tr>
                  <th>Data declarare</th>
                  <th>Parte declaranta</th>
                  <th>Cale de atac</th>
                </tr>
                <tr>
                  <td>{{ changeFormat(file.date_revoke) }}</td>
                  <td><span>{{ file.revoke_parts }}</span></td>
                  <td>{{ file.revoke_type }}</td>
                </tr>
              </table>
            </div>
            <div v-else>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Data declarare</label>
                </div>
                <div class="form-group col-md-5">
                  <datepicker-component v-model="revokeDate" :language='ro'>
                  </datepicker-component>
                </div>
              </div>
              <div v-for="part in file.parts" class="form-row">
                <div class="form-group col-md-2">
                  <label>Nume parte</label>
                </div>
                <div class="form-group col-md-6">
                  <input v-model="part.name" type="text" class="form-control" disabled>
                </div>
                <div class="form-group col-md-2">
                  <input type="checkbox" :value="part.name" v-model="checkedParts">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Nume parte</label>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" value ="Parchetul de pe langa ICCJ - Directia Nationala Anticoruptie" 
                    class="form-control" disabled>
                </div>
                <div class="form-group col-md-2">
                  <input type="checkbox" value="Parchetul de pe langa ICCJ - Directia Nationala Anticoruptie" 
                    v-model="checkedParts">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Tip</label>
                </div>
                <div class="form-group col-md-2">
                  <select v-model="revokeType">
                    <option>Apel</option>
                    <option>Contestatie</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <button @click="sendRevoke()" type="button" class="btn btn-secondary">Trimite</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end ended -->           
   
          <!-- start waiting, timePassed -->
          <div v-if="trial.type === 'waiting' && timePassed(trial.date)">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Termen de judecata</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>

            <div v-if="propsIsAdmin">
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Solutie</label>
                </div>
                <div class="form-group col-md-5">
                  <select v-model="updateType" @change="onChange(trial.court)">
                    <option>Amana cauza</option>
                    <option>Hotarare</option>
                  </select>
                </div>
              </div>

              <div v-if="updateType === 'Amana cauza'">
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label>Data rejudecarii</label>
                  </div>
                  <div class="form-group col-md-5">
                    <datepicker-component v-model="newTrialDate" :language='ro'>
                    </datepicker-component>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label>Complet</label>
                  </div>
                  <div class="form-group col-md-5">
                    <input type="text" v-model="nextCourt.name" class="form-control">
                  </div>
                  <div class="form-group col-md-2">
                    <button :disabled="newCourtIsClicked" 
                      @click="newCourt()" type="button" class="btn btn-secondary">Refuza</button>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Tip solutie</label>
                </div>
                <div class="form-group col-md-5">
                  <input type="text" v-model="solution" class="form-control">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label>Document</label>
                </div>
                <div class="form-group col-md-5">
                  <input type="text" v-model="document" class="form-control">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <button @click="updateTrials(trial.id)" type="button" class="btn btn-secondary">Actualizeaza</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end waiting, timePassed -->

          <!-- start waiting, !timePassed -->
          <div v-if="trial.type === 'waiting' && !timePassed(trial.date)">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Termen de judecata</label>
              </div>
              <div class="form-group col-md-5">
                <datepicker-component v-model="trial.date" :language='ro' disabled>
                </datepicker-component>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Complet</label>
              </div>
              <div class="form-group col-md-5">
                <input type="text" :value="trial.court.name" class="form-control" disabled>
              </div>
            </div>
          </div>
          <!-- end waiting, !timePassed -->

        </div>
      </div>
      <hr>
    </form>
  </div>
</template>

<script>
import { ro } from "vuejs-datepicker/dist/locale";
export default {
  props: ["propsFileId", "propsIsAdmin"],

  data: function () {
    return {
      file: "",
      fileNumber: "",
      updateType: "",
      solution: "",
      document: "",
      newTrialDate: new Date(),
      hasRevoke: false,
      revokeDate: new Date(),
      revokeType: "",
      nextCourt: {},
      newCourtIsClicked: false,
      crimesList: [],
      checkedParts: [],
      ro: ro,
    };
  },

  methods: {
    getFileData() {
      axios
        .post("/api/file/data", { id: this.propsFileId })
        .then((response) => {

          this.computeFileNumber(response.data[0].date_registered);

          if (response.data[0].date_revoke) 
            this.hasRevoke = true;

          this.file = response.data[0];

        })
        .catch((error) => {
          console.log(error);
        });
    },
    
    computeFileNumber(dateRegistered) {
      let parts = dateRegistered.split("-");
      this.fileNumber = this.propsFileId + "/183/" + parts[0];
    },

    getCrimes () {
      axios.post('/api/crimes/index')
        .then( response => {
          this.crimesList = response.data;
        })
        .catch( error => {
          console.log(error);
        });
    },
    
    getCheckedParts () {
      let i, str = '';
      for (i = 0; i < this.checkedParts.length - 1; i++)
          str += this.checkedParts[i] + ", ";
      str += this.checkedParts[i];
      return str;
    },

    timePassed(date) {
      if (new Date().getTime() >= new Date(date).getTime()) return true;
        return false;
    },

    onChange (court) {
        this.nextCourt = court;
    },

    newCourt () {
      axios
        .post("/api/court/new", { court_id: this.nextCourt.id })
        .then((response) => {
          console.log(response.data);
          this.nextCourt = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
      this.newCourtIsClicked = true;
    },

    sendRevoke() {
    
      let data = {
       "id": this.propsFileId,
       "revoke_date": this.revokeDate,
       "revoke_parts": this.getCheckedParts(),
       "revoke_type": this.revokeType, 
      }; 
      
      axios
        .post("/api/file/revoke", data)
        .then((response) => {
          this.getFileData();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    changeFormat(fulldate) {
      let d = new Date(fulldate),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

      if (month.length < 2) 
	  month = '0' + month;
      if (day.length < 2) 
	  day = '0' + day;

      return [day, month, year].join('/');
    },
    
    updateTrials(trial_id) {
      let data = {
        id: trial_id,
        court_id: this.nextCourt.id,
        type: this.updateType === "Amana cauza" ? "continued" : "ended",
        newtrial_date: this.newTrialDate,
        document: this.document,
        solution: this.solution,
      };

      axios
        .post("/api/trial/update", data)
        .then((response) => {
          this.file.trials = response.data;

          this.updateType = "";
          this.document = '';
          this.solution = '';
          this.newCourtIsClicked = false;
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },

  beforeMount: function () {
    this.getFileData();
    this.getCrimes();
  },

  mounted: function () {}
}
</script>

<style>
.parts > div, .trials > div {
  margin: 20px 0;
  padding-bottom: 10px;
}
.parts > div:not(:last-child), .trials > div:not(:last-child) {
  border-bottom: 1px solid rgb(206, 212, 218);
}
</style>
