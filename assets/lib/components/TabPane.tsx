import { Component } from "react";
import { NavigationTab } from "../models/models";
import React = require("react");
import { TabPaneWrapper, TabPaneTitles, TabPaneTitle } from "../styled";

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

  renderTabTitles() {
    return this.props.tabs.map((tab, index) => (
      <TabPaneTitle
        active={this.state.selectedTab.title === tab.title}
        key={index}
        onClick={() => this.selectTab(tab)}
      >
        {tab.title}
      </TabPaneTitle>
    ));
  }

  renderSelectedTab() {
    return this.state.selectedTab.content;
  }

  render() {
    return (
      <TabPaneWrapper>
        <TabPaneTitles>{this.renderTabTitles()}</TabPaneTitles>
        <div className="wpcui-tab-content">{this.renderSelectedTab()}</div>
      </TabPaneWrapper>
    );
  }
}
