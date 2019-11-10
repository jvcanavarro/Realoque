import matplotlib.pyplot as plt
import pandas as pd


mudar = {"CENTRO SAO PAULO": "CENTRO", "SANTA CECILIA": "SANTA CECÍLIA", "JARDIM PAULISTA": "JARDIM PAULISTANO", "HIGIENOPOLIS": "HIGIENÓPOLIS", "SANTA IFIGÊNIA": "SANTA EFIGÊNIA", "SANTA EFIGENIA": "SANTA EFIGÊNIA", "JARDIM RUBILANE": "JARDIM RUBILENE"}
cols = ['classe', 'numero_do_rip', 'uf', 'municipio', 'endereco', 'bairro', 'conceituacao', 'tipo_imovel', 'situacao_da_utilizacao', 'proprietario_oficial', 'regime_de_utilizacao', 'cep_do_imovel', 'valor_do_m2_do_terreno', 'valor_do_m2_de_construcao']
df = pd.read_csv('imoveis_final.csv', delimiter=';')

df.columns = cols

# unify bad named neighboorhood
df['bairro'].replace(to_replace={"CERQUEIRA CESAR": "CERQUEIRA CÉSAR", "CERQUEIRA CEZAR": "CERQUEIRA CÉSAR"},  inplace=True)
df['bairro'].replace(to_replace=mudar, inplace=True)

# normalize: subtract by the min, divide by the max

df['normal_value_terreno'] = 0
df['normal_value_construcao'] = 0


for bairro in df['bairro'].unique():
    df['normal_value_terreno'].loc[df['bairro'] == bairro] = (df['valor_do_m2_do_terreno'].loc[df['bairro'] == bairro] - df['valor_do_m2_do_terreno'].loc[df['bairro'] == bairro].min()) / (df['valor_do_m2_do_terreno'].loc[df['bairro'] == bairro].max() - df['valor_do_m2_do_terreno'].loc[df['bairro'] == bairro].min())
    df['normal_value_construcao'].loc[df['bairro'] == bairro] = (df['valor_do_m2_de_construcao'].loc[df['bairro'] == bairro] - df['valor_do_m2_de_construcao'].loc[df['bairro'] == bairro].min()) / (df['valor_do_m2_de_construcao'].loc[df['bairro'] == bairro].max() - df['valor_do_m2_de_construcao'].loc[df['bairro'] == bairro].min())

df = df.dropna()

df.to_csv('imoveis_final_bairro_merged.csv', sep=';', index=None)

expensive_neightboors = df[['bairro', 'valor_do_m2_do_terreno']].groupby('bairro').mean().sort_values(by='valor_do_m2_do_terreno', ascending=False)
expensive_locales = df[['bairro', 'valor_do_m2_de_construcao']].groupby('bairro').mean().sort_values(by='valor_do_m2_de_construcao', ascending=False)

expensive_neightboors.head(10).plot(kind='bar')
expensive_locales.head(10).plot(kind='bar')

plt.show()
