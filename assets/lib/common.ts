import { Control, DatabaseObject, Settings } from "./models/models";

export function stringToSnakeCase(input: string): string {
  const strArr = input.split(" ");
  const snakeArr = strArr.reduce((acc, val) => {
    return acc.concat(val.toLowerCase());
  }, []);
  return snakeArr.join("_");
}

/**
 * Check across all controls in every section to see
 * if the given control ID already exists.
 * @param controlId
 * @param data
 */
export function controlIdExists(
  controlId: string,
  data: DatabaseObject
): boolean {
  let exists = false;

  data.sections.forEach((section) => {
    section.controls.forEach((control) => {
      if (control.id === controlId) exists = true;
    });
  });

  return exists;
}

/**
 * Check across all sections to see if the given section ID
 * is already in use.
 * @param sectionId
 * @param data
 */
export function sectionIdExists(
  sectionId: string,
  data: DatabaseObject
): boolean {
  let exists = false;

  data.sections.forEach((section) => {
    if (section.id === sectionId) exists = true;
  });

  return exists;
}


/**
 * Get the full control ID, including the prefix (if any).
 * @param control
 * @param data
 */
export function getFullControlId(control: Control, settings: Settings) {
  return settings.controlPrefix ? `${settings.controlPrefix}_${control.id}` : control.id;
}