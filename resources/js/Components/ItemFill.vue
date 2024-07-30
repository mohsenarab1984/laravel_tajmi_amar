
     
     <template>

              
     
        <div class="my-2" style="padding: 0 3rem;">
                <div class="mx-3 d-inline-block">
                
                    
                
                    {{ item.title }}  
                </div>
    
                

                <div v-if="is_adder(item) || true">

                      <input v-if="is_number(item)" v-model="form.input_value_new"  /> 
                      <input v-else type="checkbox" v-model="form.input_ticket_new" >
                      <!-- <input   type="check" > -->
                      <button @click="updateValue">   ذخیره </button>
                    </div>
    
                <div>

                            <div class="mx-3  d-inline-block">
                                <div for="title" class="form-label d-inline-block" >نام  وارد کننده : {{ adder.name }}  </div>
                                
                            </div>
                
                            <div class="mx-3  d-inline-block me-5">
                                <div for="title" class="form-label d-inline-block" >نام    تایید کننده : {{ viewer.name }} </div>
                                
                            </div>
                
                            <div class="mx-3  d-inline-block me-5">
                                <div for="title" class="form-label d-inline-block" >نام    مشاهده کننده : {{ verifier.name }} </div>
                                
                            </div>
                </div>
    
    
                
                
        </div>

   
</template>



<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch, watchEffect } from 'vue';
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';


const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);


const props = defineProps({
    item: Object
})

function showError(){
    Object.values(page.props.errors).forEach((err)=>{
          //console.log('1117 error ::: ',err)
          toast.error(err)
    })
}


const form = useForm({
    input_value_new:null,
    input_ticket_new:null,
    type:null

})
watchEffect(()=>{
    form.input_value_new =  props.item.input_value_new
    form.input_ticket_new = props.item.input_ticket_new==1
    form.type = props.item.type
})

function updateValue(){

    form.put(`/admin/report/${props.item.id}/adder`,{
            preserveScroll:true,
            onError: (errors) => {
                   
                    showError()
                
            },
            onSuccess:(response)=>{
            
                toast.success('عملیات جدید با موفقیت ساخته شد')
                form.clearErrors()
                
            }
    })
}
 const is_number = computed(()=>(item)=>item.type == 'number')     

const is_adder = computed(()=>(item)=>user?.value.id == item.adder_id  )


const {title, adder, viewer, verifier } = props.item

</script>