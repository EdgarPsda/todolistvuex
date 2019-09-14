<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>My To-Do List</h3>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <td>#</td>
                <td>Description</td>
                <td>Due Date</td>
                <td>Actions</td>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(todo, index) in data" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ todo.description }}</td>
                <td>{{ todo.dueDate }}</td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-warning">
                      <li class="fa fa-book"></li>
                    </button>
                    <button class="btn btn-danger">
                      <li class="fa fa-trash"></li>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="panel-footer">
            <button class="btn btn-primary" @click="openModal('post')">Add ToDo</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <modal :options="modal">

    </modal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Modal from "../../components/Modal";

export default {
  data() {
    return {
      modal:{
        title: "",
        btnClass: "",
        btnTitle: ""
      }
    };
  },
  props: {
    user: {
      type: Object
    }
  },

  created() {
    this.fetchData(this.user);
  },

  computed: {
    ...mapGetters("Todo", ["data"])
  },

  methods: {
    ...mapActions("Todo", ["fetchData"]),

    openModal(action){
      if(action === "post"){
        this.modal.title = "Create a To-Do";
        this.modal.btnClass = "btn-primary";
        this.modal.btnTitle = "Save";

      }

      $("#modal").modal("show");
    },
  },

  components:{
    Modal
  }
};
</script>