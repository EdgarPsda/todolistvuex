function initialState() {
    return {
        data: {
            description: "",
            dueDate: "",
            user: {}
        },
        loading: false,
        errors: []
    };
}

const getters = {
    data: state => state.data,
    loading: state => state.loading,
    errors: state => state.errors
};

const actions = {
    storeData({ commit, state }) {
        commit("setLoading", true);

        return new Promise((resolve, reject) => {
            let params = new FormData();
            for (let fieldName in state.data) {
                let fieldValue = state.data[fieldName];
                if (typeof fieldValue !== "object") {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== "object") {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(
                                fieldName + "[" + index + "]",
                                fieldValue[index]
                            );
                        }
                    }
                }
            }
            if (_.isEmpty(state.data.description)) {
                params.set("description", "");
            } else {
                params.set("description", state.data.description);
            }
            if (_.isEmpty(state.data.dueDate)) {
                params.set("due_date", "");
            } else {
                params.set("due_date", state.data.dueDate);
            }
            if (_.isEmpty(state.data.user)) {
                params.set("user_id", "");
            } else {
                params.set("user_id", state.data.user.id);
            }
            axios
                .post("/api/v1/todolist/", params)
                .then(response => {
                    commit("resetState");
                    resolve();
                })
                .catch(error => {
                    let errors = error.response.data.message || error.message;
                    commit("setError", errors);
                    console.log(errors);
                    reject(error);
                })
                .finally(() => {
                    commit("setLoading", false);
                });
        });
    },
    fetchData({ commit, state }, user) {
        commit("setLoading", true);
        axios
            .get("/api/v1/todolist/" + user.id)
            .then(response => {
                commit("setData", response.data.data);
            })
            .catch(error => {
                message = error.response.data.message || error.message;
                commit("setError", message);
                console.log(message);
                console.log('hay error, desde index.js');
            })
            .finally(() => {
                commit("setLoading", false);
            });
    },

    setDescription({ commit }, value) {
        commit("setDescription", value);
    },
    setDueDate({ commit }, value) {
        commit("setDueDate", value);
    },
    setUserId({ commit }, user) {
        commit("setUser", user);
    },
    resetState({ commit }) {
        commit("resetState");
    },
    setError({ commit }, value) {
        commit("setError", value);
    }
};

const mutations = {
    setLoading(state, loading) {
        state.loading = loading;
    },

    setData(state, items) {
        state.data = items;
    },
    setDescription(state, description) {
        state.data.description = description;
    },
    setDueDate(state, dueDate) {
        state.data.dueDate = dueDate;
    },
    setUser(state, user) {
        state.data.user = user;
    },
    resetState(state) {
        state = Object.assign(state, initialState());
    },
    setError(state, value) {
        state.errors = value;
    }
};

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
};
