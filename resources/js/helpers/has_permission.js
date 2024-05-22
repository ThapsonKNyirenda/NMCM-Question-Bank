import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

export function useHasPermission(){
    const allPermissions = computed( () => usePage().props.auth.permissions )

    const can = (permission)=>{
        return allPermissions.value.includes(permission)
    }

    const canany = (permissions) => {
        return permissions.some( (permission) => allPermissions.value.includes(permission));
    }

    return {
        can,
        canany,
    }
}
