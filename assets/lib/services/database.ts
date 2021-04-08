import { saveData } from "./api";
import { Control, DatabaseObject, Section } from "../models/models";

export function upgrade(data): void {
  switch (data.db_version) {
    case 1:
      upgradeToVersion2(data);
      break;
  }
}

/**
 * Upgrading the database to version 2, released in v2.0.0.
 * Panels are added to this version, as well as fixing the
 * way that PHP stored the data as an object, and making it
 * stored as an array.
 * @param data
 */
function upgradeToVersion2(data): void {
  let newData: DatabaseObject = { db_version: 2, panels: [], sections: [] };

  const sections = Object.values(data.sections);
  sections.forEach((section: Section) => {
    let newSection = section;
    const controls = Object.values(section.controls);

    // clear the controls to be re-built
    newSection.controls = [];

    controls.forEach((control: Control) => {
      newSection.controls.push(control);
    });

    newData.sections.push(section);
  });

  saveData(newData).then((res) => {
    if (res.status === 200) {
      location.reload();
    }
  });
}
