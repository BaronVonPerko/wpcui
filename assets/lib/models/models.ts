import { Component } from "react";

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
  title: string;
  priority: number;
  visible: boolean;
}

export interface Notification {
  type: "success" | "warning";
  message: string;
}

export interface NavigationTab {
  title: string;
  content: any; // can be a component or simply some HTML
}
