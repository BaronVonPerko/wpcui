import { Component } from "react";
import React = require("react");
import WarningBar from "./elements/WarningBar";
import { upgrade } from "./services/database";
import { fetchData } from "./services/api";
import CustomizerEditor from "./components/CustomizerEditor";
import TabPane from "./components/TabPane";
import { connect } from "react-redux";
import store, { actions } from "./redux/wpcuiReducer";
import Notification from "./components/Notification";
import Modal from "./components/Modal";
import { DatabaseObject, NavigationTab } from "./models/models";
import { getNavigationTabs } from "./services/navigation";

interface IProps {
  data: DatabaseObject;
}
class CustomizerUI extends Component<IProps, null> {
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

  render() {
    if (this.props.data.db_version < 2 && this.props.data.db_version > 0) {
      return this.databaseUpgradeWarning();
    } else if (this.props.data.sections) {
      return (
        <section>
          <Notification />
          <Modal />
          <TabPane tabs={getNavigationTabs(this.props.data)} />
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
