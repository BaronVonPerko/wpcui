export interface DatabaseObject {
  db_version: number;
  panels: any[]; // todo : map out panel interface
  sections: Section[];
}

export interface Section {
  id: string;
  title: string;
  priority: number;
  visible: boolean;
  controls: Control[];
}

export interface Control {
  id: string;
  autoGenerateId: boolean;
  label: string;
  type: ControlType;
  priority: number;
  visible: boolean;
  default?: string;
  choices?: string[];
}

export enum ControlType {
  TEXT = 0,
  TEXT_AREA,
  DROPDOWN_PAGES,
  EMAIL,
  URL,
  NUMBER,
  DATE,
  SELECT,
  RADIO,
  COLOR_PICKER,
  UPLOAD,
  IMAGE,
}

export interface Notification {
  type: "success" | "warning";
  message: string;
}

export interface NavigationTab {
  title: string;
  content: any; // can be a component or simply some HTML
}

export interface ApplicationState {
  db_version: number;
  panels: any[]; // todo : map out panel interface
  sections: Section[];
  selectedSection?: Section;
  notification?: Notification;
  modalContent?: any;
}
