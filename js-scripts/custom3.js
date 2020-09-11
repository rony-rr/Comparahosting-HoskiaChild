
/**
 * Script para modificar el tamaño del contenido en la opcion Tabla de Comparacion 10-02-2020
 */

var changeColClass = (obj, colNumber) => {    
    obj.classList.forEach(tmp_class => {        
        if(tmp_class.includes("col-")) {            
            obj.classList.remove(tmp_class)
        }
    });
    obj.classList.add("col-md-"+colNumber);
}

var showResultPanels = (resultPanelsArray, showIndex) => {
    for(let i = 0; i < resultPanelsArray.length; i++) {
        let tmpPanels = document.querySelectorAll(resultPanelsArray[i]);
        
        let displayAttribute = (i == showIndex)? "" : "none";
        tmpPanels.forEach(tmpPanel => {
            tmpPanel.style.display = displayAttribute;
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    let pageContainer = document.querySelector(".page--container");
    let pageSideBar = document.querySelector(".page--sidebar");
    let pageMainContent = document.querySelector(".page--main-content");
    let masterLi = document.querySelector(".master-li-tab");
    let categories_li = document.querySelector(".categoria-tit, .categoria-tit-list");

    let resultPanels = ["div.resultados.detail-card", "div.resultados.list-card", "div.container--comparacards--view"];

    let detailCardButton = document.querySelector(".selector-changue-mode-view li.detail-card");
    if(detailCardButton != null) {
        detailCardButton.addEventListener("click", () => {

            pageSideBar.style.display = "";

            changeColClass(pageSideBar, 3);
            changeColClass(pageMainContent, 9);
            showResultPanels(resultPanels, 0);

            pageContainer.style.display = "";
            
        });
    }

    let listCardButton = document.querySelector(".selector-changue-mode-view li.list-card");
    if(listCardButton != null) {
        listCardButton.addEventListener("click", () => {
            
            pageSideBar.style.display = "";

            changeColClass(pageSideBar, 3);
            changeColClass(pageMainContent, 9);
            showResultPanels(resultPanels, 1);
    
            pageContainer.style.display = "";
            
        });
    }
    
    let compareCardButton = document.querySelector(".selector-changue-mode-view li.compare-card");
    if(compareCardButton != null) {
        compareCardButton.addEventListener("click", () => {
            changeColClass(pageSideBar, 12);
            changeColClass(pageMainContent, 12);
            showResultPanels(resultPanels, 2);
    
            pageContainer.style.display = "flex";
            pageContainer.style.flexDirection = "column-reverse";
            pageContainer.style.marginTop = "-15px";


            pageSideBar.style.display = "none";
        });
    }

    
    let body_pagina_actual_is_archive = document.querySelector("body");
    if( body_pagina_actual_is_archive.matches('.archive') )
    {
        const urlParams = new URLSearchParams(window.location.search);
        const is_exist_Param = urlParams.get('ctrl_llg');

        if( is_exist_Param && is_exist_Param == "membrete" ){
            
            compareCardButton.click();

        }

        pageContainer.style.marginTop = "-15px";

    }
    if( body_pagina_actual_is_archive.matches('.single-pais') ){
        
        pageContainer.style.marginTop = "-15px";
        
    }
    
});