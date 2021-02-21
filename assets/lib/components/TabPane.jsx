import React from "react";

export default class TabPane extends React.Component {
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
      <p className="tab" key={index} onClick={() => this.selectTab(tab)}>
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
