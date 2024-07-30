
     
     <template>

               
     
            <div class="my-2" style="padding: 0 3rem;">
                    <div class="mx-3 d-inline-block">
                    
                        
                    
                        {{ item.title }}
                    </div>
        
                    <div class="mx-3 d-inline-block">
                        
                        {{ item.type }}
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

const props = defineProps({
    item: Object
})

console.log('@item :',props.item)
const {title, adder, viewer, verifier } = props.item
    
</script>