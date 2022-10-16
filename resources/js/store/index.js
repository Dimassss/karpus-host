export const state = () => ({
    selectedSection: 0
});

export const getters = {
    scrollPos(state){
        return state.selectedSection
    }
};

export const mutations = {
    setScrollPos(state, val){
        state.selectedSection = val;
    }
}

export default {
    state,
    getters,
    mutations
}
