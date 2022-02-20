import { mapState } from "vuex";
export default{
    data(){
        return{
            errors:[],
            status:null
        }
    },
    methods:{
        errorFor(field){
            return this.hasError && this.errors[field]?this.errors[field]:null;
        }
    },
   
    computed:
    mapState({
        // arrow functions can make the code very succinct!
        company_id: state => state.storageData.company_id,
        user_id: state => state.storageData.user_id,
        fullname: state => state.storageData.fullname.toUpperCase(),
        email: state => state.storageData.email,
       
       hasError(){
        if(this.status == 422 && this.errors!=null){
            return true;
        }else{
            return false;
        }
    }
        
    }),
    
}