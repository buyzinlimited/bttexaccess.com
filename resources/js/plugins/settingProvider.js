import { ref } from 'vue';
import useAxios from '@/composables/useAxios.js';

export function settingProvider() {
    const setting = ref(null);
    const { sendRequest } = useAxios();

    const getCurrency = async () => {
        const response = await sendRequest({
            method: 'get',
            url: '/get-global-setting',
        });
        if (response) {
            setting.value = response.data;
        }
    };
    getCurrency();
    return {
        setting
    };
}