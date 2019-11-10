import matplotlib.pyplot as plt
import pandas as pd

df = pd.read_csv('imoveis_final.csv', delimiter=';')

mudar = {"CENTRO SAO PAULO": "CENTRO", "SANTA CECILIA": "SANTA CECÍLIA", "JARDIM PAULISTA": "JARDIM PAULISTANO", "HIGIENOPOLIS": "HIGIENÓPOLIS", "SANTA IFIGÊNIA": "SANTA EFIGÊNIA", "SANTA EFIGENIA": "SANTA EFIGÊNIA", "JARDIM RUBILANE": "JARDIM RUBILENE"}

df['Bairro'].replace(to_replace={"CERQUEIRA CESAR": "CERQUEIRA CÉSAR", "CERQUEIRA CEZAR": "CERQUEIRA CÉSAR"},  inplace=True)
df['Bairro'].replace(to_replace=mudar, inplace=True)

df.to_csv('imoveis_final_bairro_merged.csv', sep=';', index=None)


# add '$' label do data

neightboors = df.groupby('Bairro')
print(neightboors['Bairro'].head(10))

# expensive_neightboors = df[['Bairro', 'VALOR DO M2 DO TERRENO']].groupby('Bairro').mean().sort_values(by='VALOR DO M2 DO TERRENO', ascending=False)
# expensive_locales = df[['Bairro', 'VALOR DO M2 DE CONSTRUCAO']].groupby('Bairro').mean().sort_values(by='VALOR DO M2 DE CONSTRUCAO', ascending=False)

# expensive_neightboors.head(10).plot(kind='bar')
# expensive_locales.head(10).plot(kind='bar')

# plt.show()
