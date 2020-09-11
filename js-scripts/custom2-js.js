/**
 * --------------------------------------------------------------------------
 * --------- Script para enviar datos del wizard modal [16-01-2020] ---------
 * -------------------------------------------------------------------------- 
 */

/* Data */
const redirect_to = "http://" + window.location.hostname  +"/" // Url a redireccionar al finalizar el wizard
const max_step = 5; // Numero maximo de pasos que posee el wizard
const flexMoveSet = [ // Matriz que tiene el orden de instrucciones de movimiento de las traslaciones CSS Display Flex
    [3, 1, 2, 4, 5],
    [1, 3, 2, 4, 5],
    [1, 2, 3, 4, 5],
    [1, 2, 4, 3, 5],
    [1, 2, 4, 5, 3],
];

let step = 1; // Paso actual en el que se encuentra el usuario
let results = []; // Array que guardara los resultados del wizard

/* Functions */

// jQuery('.cf_processing').attr('action', 'https://stackoverflow.com/questions/5451600/jquery-to-change-form-action');

// Inicializar estilo Css Flex para poder mover el orden de los botones del wizard
function initStyleFlex () {
    // Seleccionar el agrupador de botones
    let groupButtons = document.querySelector(".cf-toggle-group-buttons");
    // Cambiar display flex a agrupador de botones
    groupButtons.style.display = "flex"; 

    // Obtener array de todos los botones del wizard
    let actionButtons = document.querySelectorAll(".cf-toggle-group-buttons .btn");
    // Indica el indice actual al recorrer botones del wizard
    let tmp_order = 0;
    // Recorrer botones del wizard y establecer # de order para flex
    actionButtons.forEach(button => {
        button.style.order = flexMoveSet[step-1][tmp_order++];
        button.setAttribute("disabled", "disabled");
        button.style.setProperty("opacity", "1", "important");
        button.style.setProperty("background-position", "center", "important");
        button.style.setProperty("padding-top", "50px", "important");
        button.style.setProperty("background-size", "35px", "important");        
        button.style.setProperty("border", "none");        

    }); 

    // Editar margin left para evitar errores por flex
    actionButtons[0].style.setProperty("margin-left", "0px", "important");
    // actionButtons[1].style.setProperty("margin-left", "76px", "important");    
}

// Funcion para cambiar el orden de los elementos Flex
function refreshStyleFlex () {
    let actionButtons = document.querySelectorAll(".cf-toggle-group-buttons .btn");
    let tmp_order = 0;
    actionButtons.forEach(button => {
        // Establecer order flez dependiendo de matriz de referencia de posicionamiento "flexMoveSet"
        button.style.order = flexMoveSet[step-1][tmp_order];

        // Cambiar color de icono
        if(flexMoveSet[step-1][tmp_order] == 3) {            
            button.style.setProperty('background-image', "url('/wp-content/themes/hoskia-child/img/wizard"+(tmp_order+1)+"_white.svg')", "important");
        } else {
            button.style.setProperty('background-image', "url('/wp-content/themes/hoskia-child/img/wizard"+(tmp_order+1)+".svg')", "important");   
        }

        // Cambiar color background
        if(tmp_order < step-1) {
            button.style.setProperty('background-color', "#E6EDFF", "important");
        } else if(tmp_order == step-1) {
            button.style.setProperty('background-color', "#3E5EFA", "important");
        } else{
            button.style.setProperty('background-color', "white", "important");
        }
        
        // Aumentar indice de button temporal recorrido
        tmp_order++;
    });

    // Editar margin left para evitar errores por flex
    if(step == 1) {
        actionButtons[0].style.setProperty("margin-left", "0px", "important");
        // actionButtons[1].style.setProperty("margin-left", "76px", "important");
    } else {
        // actionButtons[0].style.setProperty("margin-left", "76px", "important");
        actionButtons[1].style.setProperty("margin-left", "0px", "important");
    }
    
}

// Funcio para cargar un nuevo paso del wizard (Atras, Siguiente)
async function loadStep (stepNum) {    
    // Refrescar el orden de los botones con estilo Flex
    refreshStyleFlex();

    // Seleccionar boton del paso siguiente
    let actionButton = document.querySelectorAll(".cf-toggle-group-buttons .btn")[stepNum - 1];
    // Dar click al boton del paso siguiente
    actionButton.click();    

    // Ocultar botones dependiendo del paso actual del wizard
    hideNavigationButtons();

    // 
    await new Promise(r => setTimeout(r,100));

    prepareCheckboxHTML();
    //prepareQuestionsSpacing();
}

// Agregar codigo HTML de los botones de navegacion al formulario
function addNavigationButtonsHTML () {
    // Seleccionar contenedor de los botones de navegacion
    let navButtonsContainer = document.querySelector(".remodal_navigation_buttons");
    // Crear html de los botones de navegacion
    let html_code = `
        <a class='remodal_btn_nav remodal_btn_back btn'  > Anterior</a>
        <a class='remodal_btn_nav remodal_btn_next btn' id = 'abc' disabled>Siguiente </a>
        <a class='remodal_btn_nav remodal_btn_finish btn' id = 'end_wizard_post' disabled>Finalizar </a>
     
    `;
    // Agregar codigo html a contenedor
    navButtonsContainer.innerHTML = html_code;

    /* Agregar div de cuadro */
    // document.querySelector(".calderaformst").appendChild("<div class='triangulo'></div>");
    // console.log(document.getElementsByClassName("calderaformst"));
}

// Ocultar los botones de navegacion dependiendo del paso actual del wizard
function hideNavigationButtons () {
    // Obtener todos los botones d¡e navegacion
    let buttons = document.querySelectorAll(".remodal_btn_nav");
    // Ocultar todos los botones de navegacion
    buttons.forEach(button => button.style.display = "none");    
    
    // Evalluar escenario de pasos para saber que botones volver a mostrar
    if(step <= 1) {
        buttons[1].style.display = "inline"; // removal_btn_next
    } else if (step > 1 && step < max_step) {
        buttons[0].style.display = "inline"; // removal_btn_back
        buttons[1].style.display = "inline"; // removal_btn_next
    } else if(step >= max_step) {
        buttons[0].style.display = "inline"; // removal_btn_back
        buttons[2].style.display = "inline"; // removal_btn_finish
    }
}

// Funcion para guardar los datos de los forms del wizard
function refreshResults () {
    // Obtener todos los checkbox existentes en el form
    let inputs = document.querySelectorAll("div .checkbox input[type='checkbox']");
    // Contador para establecer indice al reocrrer los checkbox
    let tmp_count = 1;
    // Recorrer todos los checkboxes
    inputs.forEach(input => {
        // Si el checkbox esta seleccionado
        if(input.checked)
            results[step] = { // Guardar indice de cehckbox seleccionado en el paso a dejar
                "selected": tmp_count
            };
        // Incrementar indice de recorrido de checkboxes
        tmp_count++;
    });    
    
    if(typeof results[max_step] === 'undefined')
        document.querySelector(".remodal_btn_finish").setAttribute("disabled", "disabled");
    else
        document.querySelector(".remodal_btn_finish").removeAttribute("disabled");

}

// Funcion para enviar todos los datos del wizard y redireccionar la pagina
function finishWizard () {    
    // Variable para guardar cadena de parametros via GET
    let get_parameters = "";
    // Recorrer resultados y formar cadena de parametros GET
    results.forEach((result, index) => get_parameters+="q"+index+"="+result.selected+"&");

    // Redireccionar a URL destino y adjuntar parametros GET
    // window.location = redirect_to + "?" + get_parameters;
}

// Agregar comportamiento de radio button a checkboxes, solo permitiendo una seleccion
function radioButtonBehavior (el) {
    // Obtener todos los checkbox existentes en el form
    let inputs = document.querySelectorAll("div .checkbox input[type='checkbox']");
    // Recorrer y deschequear todos los checkboxes
    inputs.forEach(input => input.checked = false);
    // Solo chequear el seleccionado
    el.checked = true;

    // Quitar disabled a boton next despues de escoger pregunta
    document.querySelector(".remodal_btn_next").removeAttribute("disabled");
}

/* Init */
var original_country_list = [];

window.onload = () => {
    // Llamar funciones inicializadoras    
    addNavigationButtonsHTML();
    loadStep(step);
    initStyleFlex();


    /* Event Listeners */

    // Evento Click del boton siguiente
    document.querySelector(".remodal_btn_next").addEventListener("click", () => {
        loadStep(++step);
        
        // Si NO ha respondido la pregunta siguiente deshabilitar boton
        if(typeof results[step] === 'undefined')
            document.querySelector(".remodal_btn_next").setAttribute("disabled", "disabled");
    });

    // Evento Click del boton Atras
    document.querySelector(".remodal_btn_back").addEventListener("click", () => {
        loadStep(--step);

        // Si EXISTE respuesta entonces quitar deshabilitar a siguiente
        if(typeof results[step] !== 'undefined')
            document.querySelector(".remodal_btn_next").removeAttribute("disabled");
    });

    // Evento Click del boton finalizar
    document.querySelector(".remodal_btn_finish").addEventListener("click", () => finishWizard());    

    /* EVENT LISTENER FOR NON EXISTING ELEMENSTS  */
    document.addEventListener("click", event => {
        // Obtener al que se ha hecho click
        let element = event.target;

        // [CHECKBOX]:= Si el elemento es un checkbox
        if(element.tagName == "INPUT" && element.getAttribute("type") =="checkbox") {

            let isRemodalChild = element.closest(".remodal");
            if(isRemodalChild != null) {
                // Verificar que solo 1 checkbox este seleccionado
                radioButtonBehavior(element);
                // Guardar datos del form del paso actual del wizard
                refreshResults();
            }
            
        }
    })

    /**
     * Funcion para agregar evento y mostrar el cupon
     */
    document.querySelectorAll(".cupon_button_area > a").forEach(button => {     

        button.addEventListener("click", () => { revealCupon(button.closest(".cupon_area")); });
    });


    /**
     * ---------------------------------------------------------------------------------
     * --------- Script mover elemento titulo de follow us footer (20-01-2020] ---------
     * ---------------------------------------------------------------------------------
     */

    let followUsTitle = document.querySelector(".footer--widgets>.container>.row>div:nth-child(2) .footer--title");
    let ulWidgetSocial = document.querySelector(".footer--widgets>.container>.row>div:nth-child(2) .widget-social--nav");
    ulWidgetSocial.prepend(followUsTitle);


    /**
     * Callables
     */
    prepareCheckboxHTML();
    addBottomFormCheckbox();
    // changeImgContainer();
    addStrikeElement();

    let root = document.querySelector(".lista-paises");
    if(root != undefined) {
        original_country_list = Array.prototype.slice.call(root.querySelectorAll("a"));

        let pageWidth = document.querySelector("body").clientWidth;
        if(pageWidth < 992) {
            countryListSortMobile();
        } else {
            countryListSort();
        }
    }
    
    
    addClearBoth();


    
}

/**
 * -------------------------------------------------------------------------------
 * ---------- Script para preparar html para cambiar estilo de checkbox ----------
 * -------------------------------------------------------------------------------
 */

function prepareCheckboxHTML () {
    document.querySelectorAll(".checkbox").forEach(function(item) {        
        let checkmark = document.createElement("label");
        checkmark.setAttribute("class", "checkbox-checkmark");
        checkmark.setAttribute("for", item.children[0].children[0].getAttribute("id"));
        checkmark.addEventListener("click", () => item.children[0].children[0].click());

        item.children[0].setAttribute("class", "checkbox-container");
        item.children[0].style.setProperty("padding", "0px", "important");
        item.children[0].appendChild(checkmark);
    });
}

let firstEntryPrepareQuestionsSpacing = true;
function prepareQuestionsSpacing() {
    let questionsContainer = document.querySelector("#CF5df8f32536959_1-row-14");

    if(firstEntryPrepareQuestionsSpacing) {
        questionsContainer.removeChild(questionsContainer.children[0]);
        questionsContainer.removeChild(questionsContainer.children[questionsContainer.children.length -1]);
        firstEntryPrepareQuestionsSpacing = false;
    }
    

    Array.from(questionsContainer.children).forEach(function(item) {
        item.setAttribute("class", "col-md-4");
        item.style.paddingLeft = "40px";
        // item.style.border = "1px solid black";
    })

    questionsContainer.style.width = "90%";
    questionsContainer.style.marginLeft = "35px";

    // console.log(questionsContainer);
}


// Funcion para agregar Checkbox HTML al formulario del fondo
function addBottomFormCheckbox () {
    let target = document.querySelector(".wpcf7-form");
    let html_code = `
        <p>
            <span class="wpcf7-form-control-wrap wpgdprc">
                <span class="wpcf7-form-control wpcf7-validates-as-required wpcf7-wpgdprc">
                    <span class="wpcf7-list-item"><input type="checkbox" name="wpgdprc" value="1" aria-required="true" aria-invalid="false">
                        <span class="wpcf7-list-item-label">Al utilizar este formulario, aceptas el almacenamiento y manejo de tus datos por este sitio web.
                        </span>
                    </span>
                </span>
            </span>
        </p>
    `;

    if(target != undefined)
        target.insertAdjacentHTML('beforeend', html_code);
}

// Funcion para cambiar contenedor de imagen de cajitas de precios
/*
function changeImgContainer () {
    let oldContainer = document.querySelectorAll(".pricing--content .pricing--icon");
    let newContainer = document.querySelectorAll(".pricing--content .pricing--header");    

    for(let i = 0; i< oldContainer.length; i++) {
        let img = oldContainer[i].getElementsByTagName("img")[0];
        newContainer[i].insertBefore(img, newContainer[i].children[1]);
    }    
}
*/

// Funcion para agregar strike element a subheading
function addStrikeElement () {
    let subtitle = document.querySelectorAll(".pricing--header .h5");

    subtitle.forEach(item => {
        let el = item.childNodes[0];
        let strikeTag = document.createElement("strike");
        el.parentNode.insertBefore(strikeTag, el);
        strikeTag.appendChild(el);    
    })    
}


// Reordenar lista de paises dependiendo si se ve en desktop o en mobil
window.addEventListener("resize", function () {
    let pageWidth = document.querySelector("body").clientWidth;
    if(pageWidth < 992) {
        countryListSortMobile();        
    } else {
        countryListSort();        
    }
});

// Funcion para ordenar a los paises en Desktop
function countryListSort() {    
    let root = document.querySelector(".lista-paises");
    let paises = original_country_list.slice();

    let sortedPaises = Array(20);

    let c1 = 1;
    let c2 = 1;    
    for(let i = 1; i <= paises.length; i++) {
        let newIndex = c1 + 4 * (i - c2);
        let newItem = document.createElement("a");
        newItem.innerHTML = paises[i - 1].innerHTML;
        newItem.addEventListener("click", () => {
            paises[i - 1].children[0].click();
        });
        
        if(newIndex == 11)
            newItem.setAttribute("class", "eleven_country");
        else if(newIndex == 12)
            newItem.setAttribute("class", "twelve_country");        
        
        sortedPaises[newIndex - 1] = newItem;        
        
        if(i % 5 == 0){
            c1 = c1 + 1;
            c2 = c2 + 5;
        }
    }

    if(root != null) {
        root.innerHTML = "";
        sortedPaises.forEach(item => {
            root.appendChild(item);
        });
    }
    

}

// Funcion para ordenar a los paises en Mobile
function countryListSortMobile () {
    let root = document.querySelector(".lista-paises");
    let paises = original_country_list.slice();

    let sortedPaises = Array(20);
    let c1 = 1;
    let c2 = 0;
    for(let i = 1; i <= paises.length; i++) {
        let newItem = document.createElement("a");
        newItem.innerHTML = paises[i - 1].innerHTML;
        newItem.addEventListener("click", () => {
            paises[i - 1].children[0].click();
        });

        if(c1 + c2 == 11)
            newItem.setAttribute("class", "eleven_country");
        else if(c1 + c2 == 12)
            newItem.setAttribute("class", "twelve_country");  

        sortedPaises[c1 + c2 - 1] = newItem;
        c1 = c1 + 2;

        if(i % 5 == 0) {
            c1 = 2;
        }

        if(i % 10 == 0) {
            c1 = 1;
            c2 += 10;
        }
    }

    if(root != null) {
        root.innerHTML = "";
        sortedPaises.forEach(item => {
            root.appendChild(item);
        });
    }
    
}


function addClearBoth () {
    let parentTargets = document.querySelectorAll(".options-items-map");
    parentTargets.forEach(parentTarget => {
        let target = parentTarget.querySelector(".selects-items");
        let newDiv = document.createElement("div");
        newDiv.style.clear = "both";
        
        target.appendChild(newDiv);        
    });
    
    /*let newDiv = document.createElement("div");
    newDiv.style.clear = "both";

    targets.forEach(target => {
        target.children[0].appendChild(newDiv);
        target.children[].children[2].style.transform = "translateX(50%)";
    });
    */    
}


/**
 * -----------------------------------------------------------------------
 * ---------- Script para mostrar codigo de cupon y redireccion ----------
 * -----------------------------------------------------------------------
 */

function revealCupon (cupon_area_obj) {
    let time_to_redirect    =   1500;

    let cupon_button_area   =   cupon_area_obj.querySelector(".cupon_button_area");
    let cupon_reveal_area   =   cupon_area_obj.querySelector(".cupon_reveal_area");
    let cupon_reveal_area_redire   =   cupon_area_obj.querySelector(".redirec_host");
    let txt_cupon           =   cupon_reveal_area.querySelector(".txt_cupon");
    let txt_cupon_url       =   cupon_reveal_area.querySelector(".txt_cupon_url");
    let texto_saved         =   cupon_area_obj.querySelector(".cupon_reveal_area p b");

    // Mostrar cupon y ocultar boton
    cupon_button_area.style.display = "none";
    cupon_reveal_area.style.display = "none";
    setTimeout(() => { 
        cupon_reveal_area.style.display = "none";
        cupon_reveal_area_redire.style.display = "inherit";
    },1500);

    // Copiar cupon en portapapeles
    // window.getSelection().removeRange(range);
    var range = document.createRange();
    range.selectNode(texto_saved);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
  
    try {
      // intentar copiar el contenido seleccionado
      var resultado = document.execCommand('copy');
      //console.log(resultado ? 'copiado' : 'No se pudo copiar');
      //

    } catch(err) {
        //   console.log('ERROR al intentar copiar');
        null;
    }

    // Hacer redireccion
    setTimeout(() => { window.open(txt_cupon_url.value , '_blank'); }, time_to_redirect);

    
}
