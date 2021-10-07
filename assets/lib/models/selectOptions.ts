import { ControlType } from "./models";

export interface SelectOption {
  text: string;
  value: ControlType
}

export const ControlTypeSelectOptions: SelectOption[] = [
  { text: "Text", value: ControlType.TEXT },
  { text: "Text Area", value: ControlType.TEXT_AREA },
  { text: "Dropdown Pages", value: ControlType.DROPDOWN_PAGES },
  { text: "Email", value: ControlType.EMAIL },
  { text: "URL", value: ControlType.URL },
  { text: "Number", value: ControlType.NUMBER },
  { text: "Date", value: ControlType.DATE },
  { text: "Select", value: ControlType.SELECT },
  { text: "Radio", value: ControlType.RADIO },
  { text: "Color Picker", value: ControlType.COLOR_PICKER },
  { text: "Upload", value: ControlType.UPLOAD },
  { text: "Image", value: ControlType.IMAGE }
];

export const ControlTypesWithOptions: ControlType[] = [
  ControlType.SELECT,
  ControlType.RADIO
];

export function GetControlTypeById(id: number) : SelectOption {
  return ControlTypeSelectOptions[id];
}