import { DatabaseObject, NavigationTab } from "../models/models";
import CustomizerEditor from "../components/CustomizerEditor";
import Settings from "../components/Settings";
import React = require("react");

export function getNavigationTabs(data: DatabaseObject): NavigationTab[] {
  let tabs: NavigationTab[] = [];

  tabs.push({
    title: "Editor",
    content: <CustomizerEditor data={data} />
  });
  tabs.push({ title: "Settings", content: <Settings data={data} /> });

  return tabs;
}
