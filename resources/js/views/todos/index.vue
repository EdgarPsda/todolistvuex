<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3>My Tasks</h3>
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
            <button class="btn btn-primary" @click="openModal('post')">Add task</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <modal :options="modal">
      <div slot="body">
        <form @submit.prevent>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea
              class="form-control"
              id="description"
              name="description"
              cols="30"
              rows="3"
              :value="data.description"
              @input="updateDescription"
            ></textarea>
            <div
              v-if="errors.description"
              class="alert alert-danger"
              role="alert"
            >{{ errors }}</div>
          </div>
          <div class="form-group">
            <label for="dueDate">Due date</label>
            <input
              type="date"
              class="form-control"
              name="dueDate"
              :value="data.dueDate"
              @input="updateDueDate"
            />
            <div
              v-if="errors.message"
              class="alert alert-danger"
              role="alert"
            >{{ errors.due_date[0] }}</div>
          </div>
        </form>
      </div>
    </modal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Modal from "../../components/Modal";

export default {
  data() {
    return {
      modal: {
        title: "",
        btnClass: "",
        btnTitle: ""
      },
      actionType: ""
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
    ...mapGetters("Todo", ["data", "errors"])
  },

  methods: {
    ...mapActions("Todo", [
      "fetchData",
      "setDescription",
      "setDueDate",
      "setUserId",
      "storeData",
      "resetState",
      "setError"
    ]),

    openModal(action) {
      if (action === "post") {
        this.actionType = "post";
        this.modal.title = "Create a Task";
        this.modal.btnClass = "btn-primary";
        this.modal.btnTitle = "Save task";
      }

      $("#modal").modal("show");
    },
    updateDescription(e) {
      this.setDescription(e.target.value);
    },
    updateDueDate(e) {
      this.setDueDate(e.target.value);
    },
    formAction() {
      if (this.actionType == "post") {
        this.setUserId(this.user);
        this.storeData()
          .then(() => {
            this.fetchData(this.user);
            this.setError;
            $("#modal").modal("hide");
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    eventRegistration() {
      Event.$on("modal:submit", () => {
        this.formAction();
      });
    }
  },

  components: {
    Modal
  },
  mounted() {
    this.eventRegistration();
  }
};
</script>
