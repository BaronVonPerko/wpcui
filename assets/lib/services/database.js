import {saveData} from "./api";

export function upgrade(data) {
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
function upgradeToVersion2(data) {
    let newData = {db_version: 2, panels: [], sections: []};

    const sections = Object.values(data.sections);
    sections.forEach(section => {
        let newSection = section;
        const controls = Object.values(section.controls);

        // clear the controls to be re-built
        newSection.controls = [];

        controls.forEach(control => {
            newSection.controls.push(control);
        });

        newData.sections.push(section);
    });

    saveData(newData).then(res => console.log(res));
}