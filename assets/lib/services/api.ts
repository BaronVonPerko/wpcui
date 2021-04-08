import axios from "axios";
import { DatabaseObject } from "../models/models";

export async function fetchData() {
  const res = await axios.get("/wp-json/wpcui/v2/getOptions");

  return res.data;
}

export async function saveData(data) {
  return await axios.put("/wp-json/wpcui/v2/saveOptions", {
    data: prepareData(data),
  });
}

/**
 * Remove data that should not persist to the database.
 *
 * @param data
 */
function prepareData(data): DatabaseObject {
  return {
    db_version: data.db_version,
    panels: data.panels,
    sections: data.sections,
  };
}
