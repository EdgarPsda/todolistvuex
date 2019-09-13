function initialState() {
    return {
        data: [],
        loading: false
    }
}

const getters = {
    data: state => state.data,
    loading: state => state.loading,
}

const actions = {
    fetchData({ commit, state }, user) {
        commit('setLoading', true)
        axios.get('/api/v1/todolist/' + user.id)
            .then(response => {
                commit('setData', response.data.data)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    }
}

const mutations = {
    setLoading(state, loading) {
        state.loading = loading
    },

    setData(state, items) {
        state.data = items
    }

}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}