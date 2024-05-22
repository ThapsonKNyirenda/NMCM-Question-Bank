import {reactive} from "vue";

export const store = reactive({
    showSidebar: false,
    showChatDrawer: false,
    pageTitle: 'Dashboard',
    breadCrumb:{},
    toggleSidebar(){
        this.showSidebar = !this.showSidebar
    },
    toggleChatDrawer(){
        this.showChatDrawer = !this.showChatDrawer
    },
    removeSidebar(){
        this.showSidebar = false;
    },
    setPageTitle(title){
        this.pageTitle = title
    },
    setBreadCrumb(title){
        this.breadCrumb = title
    },
    startProgressBar(){
        document.getElementById("loading").style.display = "block";
    },
    stopProgressBar(){
        document.getElementById("loading").style.display = "none";
    }
})
