
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';
export function  showErrorProps_Toast(errors_obj){
    // errors_obj is page.props.errors
    Object.values(errors_obj).forEach((err)=>{
          //console.log('1117 error ::: ',err)
          toast.error(err)
    })
}