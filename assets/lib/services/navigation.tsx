import { DatabaseObject, NavigationTab } from "../models/models";
import CustomizerEditor from "../components/CustomizerEditor";
import React = require("react");

export function getNavigationTabs(data: DatabaseObject): NavigationTab[] {
  let tabs: NavigationTab[] = [];

  tabs.push({
    title: "Editor",
    content: <CustomizerEditor data={data} />,
  });
  tabs.push({ title: "Settings", content: <p>Settings Coming Soon...</p> });

  return tabs;
}
