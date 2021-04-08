import { Component } from "react";
import { NavigationTab } from "../models/models";
import React = require("react");

interface IProps {
  tabs: NavigationTab[];
}
interface IState {
  selectedTab: NavigationTab;
}

export default class TabPane extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = { selectedTab: this.props.tabs[0] };

    this.selectTab = this.selectTab.bind(this);
  }

  selectTab(tab) {
    this.setState({ selectedTab: tab });
  }

  getTabClassName(tab) {
    return tab.title === this.state.selectedTab.title
      ? "wpcui-tab active"
      : "wpcui-tab";
  }

  renderTabTitles() {
    return this.props.tabs.map((tab, index) => (
      <p
        className={this.getTabClassName(tab)}
        key={index}
        onClick={() => this.selectTab(tab)}
      >
        {tab.title}
      </p>
    ));
  }

  renderSelectedTab() {
    return this.state.selectedTab.content;
  }

  render() {
    return (
      <div className="wpcui-tab-pane">
        <div className="wpcui-tab-titles">{this.renderTabTitles()}</div>
        <div className="wpcui-tab-content">{this.renderSelectedTab()}</div>
      </div>
    );
  }
}
