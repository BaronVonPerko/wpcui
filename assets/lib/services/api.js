import axios from "axios";

export async function fetchData() {
  const res = await axios.get("/wp-json/wpcui/v2/getOptions");

  return res.data;
}

export async function saveData(data) {
  return await axios.put("/wp-json/wpcui/v2/saveOptions", {
    data: scrubData(data),
  });
}

/**
 * Remove data that should not persist to the database.
 *
 * @param data
 */
function scrubData(data) {
  delete data.selectedSection;
  delete data.notification;
  delete data.modalContent;

  return data;
}
