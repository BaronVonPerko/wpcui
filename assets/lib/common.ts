import { DatabaseObject } from "./models/models";

export function stringToSnakeCase(input: string): string {
  const strArr = input.split(" ");
  const snakeArr = strArr.reduce((acc, val) => {
    return acc.concat(val.toLowerCase());
  }, []);
  return snakeArr.join("_");
}

export function controlIdExists(
  controlId: string,
  data: DatabaseObject
): boolean {
  const exists = false;

  data.sections.forEach((section) => {
    section.controls.forEach((control) => {
      if (control.id === controlId) exists = true;
    });
  });

  return exists;
}
