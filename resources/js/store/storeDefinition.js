import createPersistedState from "vuex-persistedstate";

export default{
    state:{
        storageData:{
            company_id:null,
            user_id:null,
            fullname:null,
            email:null,
            
        }
    },
    mutations:{
        setstorageData(state,payload){
            state.storageData = payload;
        },
        
    },
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    // getters: {
    //     itemsCount: state => {
    //       return state.basket.items.length
    //     }
    //   }
}