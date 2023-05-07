module.exports = {
  webpack: function (config) {
    let definePluginDelta;
    for (const delta in config.plugins) {
      if (config.plugins[delta].constructor.name == 'DefinePlugin') {
        definePluginDelta = delta;
      }
    }
    config.plugins[definePluginDelta].definitions['process.env']['DDEV_PRIMARY_URL'] = JSON.stringify(process.env.DDEV_PRIMARY_URL);
    config.plugins[definePluginDelta].definitions['process.env']['DDEV_HOSTNAME'] = JSON.stringify(process.env.DDEV_HOSTNAME);
    return config;
  },
}
