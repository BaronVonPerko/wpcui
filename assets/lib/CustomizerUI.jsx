import React from "react";
import WarningBar from "./elements/WarningBar";
import { upgrade } from "./services/database";
import { fetchData } from "./services/api";
import CustomizerEditor from "./components/CustomizerEditor";
import TabPane from "./components/TabPane";
import { connect } from "react-redux";
import store, { actions } from "./redux/wpcuiReducer";

class CustomizerUI extends React.Component {
  constructor(props) {
    super(props);

    this.upgradeDatabase = this.upgradeDatabase.bind(this);
  }

  componentDidMount() {
    fetchData().then((data) => {
      store.dispatch({
        type: actions.DATA_FETCH,
        data,
      });
    });
  }

  upgradeDatabase() {
    upgrade(this.props.data);
  }

  databaseUpgradeWarning() {
    return (
      <WarningBar
        title="Database Upgrade Required"
        buttonText="Upgrade Now"
        buttonClick={this.upgradeDatabase}
        innerText="Your database needs to be updated in order to use this version of the Customizer UI plugin.  It is recommended that you create a backup of your database before continuing."
      />
    );
  }

  getTabs() {
    let tabs = [];

    tabs.push({
      title: "Editor",
      content: <CustomizerEditor data={this.props.data} />,
    });
    tabs.push({ title: "Settings", content: <p>Settings Coming Soon...</p> });

    return tabs;
  }

  render() {
    if (this.props.data.db_version < 2 && this.props.data.db_version > 0) {
      return this.databaseUpgradeWarning();
    } else if (this.props.data.sections) {
      return (
        <section>
          <TabPane tabs={this.getTabs()} />
        </section>
      );
    } else {
      return <p>Loading ...</p>;
    }
  }
}

const mapStateToProps = (state) => ({
  data: state,
});
export default connect(mapStateToProps)(CustomizerUI);
