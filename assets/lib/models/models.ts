export interface DatabaseObject {
  db_version: string;
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
  title: string;
  priority: number;
  visible: boolean;
}
