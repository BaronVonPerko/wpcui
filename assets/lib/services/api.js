import axios from "axios";

export async function fetchData() {
    const res = await axios.get('/wp-json/wpcui/v2/getOptions');
    
    return res.data;
}