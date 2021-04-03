window.ValidateForm = function(section = document){
    let count = 0;
    count += ValidateInput(section);
    count += ValidateSelector(section);
    count += ValidateFile(section);
    count += ValidateTextArea(section);

    if(count!=0){
        MessageObject.VaildSubmitMessage("驗證發生錯誤","必填欄位一定要填");
        return false
    }

    return true
}


function ValidateInput(section = document){
        
    const lists = section.getElementsByClassName("necessary");

    let count = 0;

    for(let i = 0; i < lists.length; i++){
            if(lists[i].value.trim() == ""|| lists[i].value === "error"){
                lists[i].classList.add("is-invalid");
                count++
            } else {
                lists[i].classList.remove("is-invalid");
            }
         }
         return count;
    }

function ValidateSelector(section = document){
        
        const selectors = section.getElementsByClassName("necessarySelect");
    
        let count = 0;
    
        for(let i = 0; i < selectors.length; i++){
                if(
                    selectors[i].options[selectors[i].selectedIndex].value == 0 ||
                    selectors[i].options[selectors[i].selectedIndex].disabled
                ) {
                    selectors[i].classList.add("is-invalid");
                    count++
                } else {
                    console.log(selectors[i].options[selectors[i].selectedIndex]);
                    selectors[i].classList.remove("is-invalid");
                }
             }

             if(count!=0){
       
                if($(".tags").find(".error").length==0){

                $('.tags').append('<h4 class="error"><span class="badge badge-pill badge-error">請記得按新增Tag</span></h4>');

                }

             }

            return count;
     }
 
function ValidateFile(section = document){

    const files = section.getElementsByClassName("necessaryFile");
    
        let count = 0;

      $.each(files , function(index,input){

            if(input.value == ""){

                $(this).parent(".preview").addClass("error");
                count++

            } else {

                $(this).parent(".preview").removeClass("error");

            }

            });

             return count;
        }
        
function ValidateTextArea(section = document){
        
    let textarea = section.getElementById("content");
        
    let count = 0;

        if(textarea.value === ""){

            $("#content").addClass("is-invalid");

            count++

        } else {

            $("#content").removeClass("is-invalid");

        }
            
        return count;
 }