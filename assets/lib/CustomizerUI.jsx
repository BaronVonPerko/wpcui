import React from 'react';
import WarningBar from "./elements/WarningBar";
import {upgrade} from './services/database';
import {fetchData} from "./services/api";
import CustomizerEditor from "./components/CustomizerEditor";

export default class CustomizerUI extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            data: {}
        }

        this.upgradeDatabase = this.upgradeDatabase.bind(this);
    }

    componentDidMount() {
        fetchData().then(data => this.setState({data}));
    }

    upgradeDatabase() {
        upgrade(this.state.data)
    }

    databaseUpgradeWarning() {
        return (
            <WarningBar
                title="Database Upgrade Required"
                buttonText="Upgrade Now"
                buttonClick={this.upgradeDatabase}
                innerText="Your database needs to be updated in order to use this version of the Customizer UI plugin.  It is recommended that you create a backup of your database before continuing."/>
        )
    }

    render() {
        if (this.state.data.db_version < 2) {
            return this.databaseUpgradeWarning();
        } else if (this.state.data.sections) {
            return (
                <CustomizerEditor data={this.state.data} />
            )
        } else {
            return (
                <p>Loading ...</p>
            )
        }
    }
}